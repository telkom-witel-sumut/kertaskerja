<?php

namespace App\Services\Activity;
use App\Jobs\ClassifyActivityJob;
use App\Models\Activity;

use PhpOffice\PhpSpreadsheet\IOFactory;
use RuntimeException;
use App\Models\ActivityImport;
use Illuminate\Support\Facades\DB;
class ActivityImportService
{
    private const REQUIRED_HEADERS = [
        'nik',
        'name',
        'role',
        'am_type',
        'division',
        'segment',
        'regional',
        'witel',
        'ca_name',
        'nipnas',
        'id',
        'activity_start_date',
        'activity_end_date',
        'createdat',
        'label',
        'activity_type',
        'activity_notes',
        'nama_pic_1',
        'jabatan_pic_1',
        'peran_pic_1',
    ];

    private const MAX_HEADER_SCAN_ROWS = 5;
    private const REQUIRED_ACTIVITY_FIELDS = [
        'source_id',
        'name',
        'activity_start_date',
        'activity_notes',
    ];
    public function import($file, ?int $uploadedBy = null): array
    {
        $spreadsheet = IOFactory::load($file->getRealPath());

        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray();

        if (empty($rows)) {
            throw new RuntimeException('Excel tidak memiliki data.');
        }

        $headerInfo = $this->findHeaderRow($rows);

        $headerRowIndex = $headerInfo['index'];
        $headers = $headerInfo['headers'];

        $dataRows = array_slice($rows, $headerRowIndex + 1);

        $headerMap = array_flip($headers);

        return DB::transaction(function () use ($file, $dataRows, $headerMap, $headerRowIndex, $headers, $uploadedBy) {
            $import = ActivityImport::create([
                'uploaded_by' => $uploadedBy,
                'file_name' => $file->getClientOriginalName(),
                'total_rows' => count($dataRows),
                'valid_rows' => 0,
                'invalid_rows' => 0,
                'processed_rows' => 0,
                'classified_rows' => 0,
                'review_required_rows' => 0,
                'unclassified_rows' => 0,
                'status' => 'processing',
            ]);

            $stagingRows = [];
            $validRows = 0;
            $invalidRows = 0;

            foreach ($dataRows as $offset => $row) {
                $sourceRow = $headerRowIndex + $offset + 2;

                $stagingRow = [
                    'import_id' => $import->id,
                    'source_row' => $sourceRow,
                    'source_id' => $row[$headerMap['id']] ?? null,
                    'nik' => $row[$headerMap['nik']] ?? null,
                    'name' => $row[$headerMap['name']] ?? null,
                    'role' => $row[$headerMap['role']] ?? null,
                    'am_type' => $row[$headerMap['am_type']] ?? null,
                    'division' => $row[$headerMap['division']] ?? null,
                    'segment' => $row[$headerMap['segment']] ?? null,
                    'regional' => $row[$headerMap['regional']] ?? null,
                    'witel' => $row[$headerMap['witel']] ?? null,
                    'ca_name' => $row[$headerMap['ca_name']] ?? null,
                    'nipnas' => $row[$headerMap['nipnas']] ?? null,
                    'activity_start_date' => $row[$headerMap['activity_start_date']] ?? null,
                    'activity_end_date' => $row[$headerMap['activity_end_date']] ?? null,
                    'created_at_source' => $row[$headerMap['createdat']] ?? null,
                    'label' => $row[$headerMap['label']] ?? null,
                    'activity_type' => $row[$headerMap['activity_type']] ?? null,
                    'activity_notes' => $row[$headerMap['activity_notes']] ?? null,
                    'validation_status' => 'pending',
                    'validation_errors' => null,
                    'classification_status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'nama_pic_1' => $row[$headerMap['nama_pic_1']] ?? null,
                    'jabatan_pic_1' => $row[$headerMap['jabatan_pic_1']] ?? null,
                    'peran_pic_1' => $row[$headerMap['peran_pic_1']] ?? null,
                ];

                if ($this->isEmptySourceRow($row)) {
                    $stagingRow['validation_status'] = 'empty';
                    $stagingRow['validation_errors'] = null;
                } else {
                    $errors = $this->validateActivityRow($stagingRow);

                    if (!empty($errors)) {
                        $stagingRow['validation_status'] = 'invalid';
                        $stagingRow['validation_errors'] = json_encode($errors);
                        $invalidRows++;
                    } else {
                        $stagingRow['validation_status'] = 'valid';
                        $validRows++;
                    }
                }

                $stagingRows[] = $stagingRow;
            }

            foreach (array_chunk($stagingRows, 500) as $chunk) {
                DB::table('activity_import_rows')->insert($chunk);
            }

            $import->update([
                'valid_rows' => $validRows,
                'invalid_rows' => $invalidRows,
                'processed_rows' => count($stagingRows),
                'status' => 'preview',
            ]);

            return [
                'import_id' => $import->id,
                'total_rows' => count($stagingRows),
                'valid_rows' => $validRows,
                'invalid_rows' => $invalidRows,
                'header_row' => $headerRowIndex + 1,
                'headers' => $headers,
            ];
        });
    }


    private function findHeaderRow(array $rows): array
    {
        $maxRows = min(
            count($rows),
            self::MAX_HEADER_SCAN_ROWS
        );

        if ($maxRows === 0) {
            throw new RuntimeException('Excel tidak memiliki baris header.');
        }
        $bestMatchedHeaders = [];
        $bestMissingHeaders = self::REQUIRED_HEADERS;
        $bestIndex = null;
        $bestMatchCount = 0;

        for ($index = 0; $index < $maxRows; $index++) {
            $headers = $this->normalizeHeaders($rows[$index]);

            $matchedHeaders = array_intersect(
                self::REQUIRED_HEADERS,
                $headers
            );

            $missingHeaders = array_diff(
                self::REQUIRED_HEADERS,
                $headers
            );

            $matchCount = count($matchedHeaders);

            if ($matchCount > $bestMatchCount) {
                $bestMatchCount = $matchCount;
                $bestMatchedHeaders = $headers;
                $bestMissingHeaders = $missingHeaders;
                $bestIndex = $index;
            }

            if (empty($missingHeaders)) {
                return [
                    'index' => $index,
                    'headers' => $headers,
                ];
            }
        }

        throw new RuntimeException(
            'Header Excel tidak sesuai. '
            . 'Header yang tidak ditemukan: '
            . implode(', ', $bestMissingHeaders)
        );
    }
    private function normalizeHeaders(array $headers): array
    {
        return array_map(function ($header) {
            return strtolower(trim((string) $header));
        }, $headers);
    }

    private function validateActivityRow(array $activity): array
    {
        $errors = [];

        foreach (self::REQUIRED_ACTIVITY_FIELDS as $field) {
            $value = $activity[$field] ?? null;

            if ($value === null || trim((string) $value) === '') {
                $errors[] = "{$field} wajib diisi.";
            }
        }

        return $errors;
    }

    private function isEmptySourceRow(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    public function confirm(ActivityImport $import): void
    {
        DB::transaction(function () use ($import) {
            if ($import->status !== 'preview') {
                throw new RuntimeException(
                    'Import tidak dapat dikonfirmasi pada status saat ini.'
                );
            }

            $validRows = $import->rows()
                ->where('validation_status', 'valid')
                ->get();

            $seenSourceIds = [];
            $newSourceIds = [];

            foreach ($validRows->chunk(500) as $chunk) {

                $sourceIds = $chunk
                    ->pluck('source_id')
                    ->map(fn($sourceId) => trim((string) $sourceId))
                    ->filter()
                    ->unique()
                    ->values();

                $existingSourceIds = DB::table('activities')
                    ->whereIn('source_id', $sourceIds)
                    ->pluck('source_id')
                    ->map(fn($sourceId) => trim((string) $sourceId))
                    ->all();

                $existingLookup = array_fill_keys($existingSourceIds, true);

                $activities = $chunk
                    ->filter(function ($row) use ($existingLookup, &$seenSourceIds) {
                        $sourceId = trim((string) $row->source_id);

                        if ($sourceId === '') {
                            return false;
                        }

                        if (isset($existingLookup[$sourceId])) {
                            return false;
                        }

                        // Duplicate dalam batch yang sama.
                        if (isset($seenSourceIds[$sourceId])) {
                            return false;
                        }

                        $seenSourceIds[$sourceId] = true;

                        return true;
                    })
                    ->map(function ($row) {
                        return [
                            'import_id' => $row->import_id,
                            'source_id' => trim((string) $row->source_id),
                            'source_row' => $row->source_row,
                            'nik' => $row->nik,
                            'name' => $row->name,
                            'role' => $row->role,
                            'am_type' => $row->am_type,
                            'division' => $row->division,
                            'segment' => $row->segment,
                            'regional' => $row->regional,
                            'witel' => $row->witel,
                            'ca_name' => $row->ca_name,
                            'nipnas' => $row->nipnas,
                            'activity_start_date' => $row->activity_start_date,
                            'activity_end_date' => $row->activity_end_date,
                            'created_at_source' => $row->created_at_source,
                            'label' => $row->label,
                            'activity_type' => $row->activity_type,
                            'activity_notes' => $row->activity_notes,
                            'classification_status' => 'pending',
                            'nama_pic_1' => $row->nama_pic_1,
                            'jabatan_pic_1' => $row->jabatan_pic_1,
                            'peran_pic_1' => $row->peran_pic_1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })
                    ->values()
                    ->all();

                if (!empty($activities)) {
                    DB::table('activities')->insert($activities);

                    foreach ($activities as $activity) {
                        $newSourceIds[] = $activity['source_id'];
                    }
                }
            }

            $import->update([
                'status' => 'confirmed',
            ]);

            if (!empty($newSourceIds)) {

                $activityIds = Activity::query()
                    ->where('import_id', $import->id)
                    ->whereIn('source_id', $newSourceIds)
                    ->pluck('id');

                foreach ($activityIds as $activityId) {
                    ClassifyActivityJob::dispatch($activityId)
                        ->afterCommit();
                }
            }
        });
    }
}