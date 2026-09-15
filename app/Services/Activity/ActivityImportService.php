<?php

namespace App\Services\Activity;

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

                $errors = $this->validateActivityRow($stagingRow);

                if (!empty($errors)) {
                    $stagingRow['validation_status'] = 'invalid';
                    $stagingRow['validation_errors'] = json_encode($errors);
                    $invalidRows++;
                } else {
                    $stagingRow['validation_status'] = 'valid';
                    $validRows++;
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

    public function confirm(ActivityImport $import): void
    {

    }
}