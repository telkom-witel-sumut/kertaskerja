<?php

namespace App\Http\Controllers;

use App\Services\Activity\ActivityImportService;
use App\Models\ActivityImport;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RuntimeException;

class IntimacyMonitoringController extends Controller
{
    private ActivityImportService $activityImportService;

    public function __construct(ActivityImportService $activityImportService)
    {
        $this->activityImportService = $activityImportService;
    }

    public function dashboard(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = date('Y');

        $rawAmData = collect([
            'Nama AM 3' => collect([
                ['ca_name' => 'Pemkab Deli Serdang', 'local_gov' => 4, 'local_partners' => 4, 'national_partners' => 4, 'nap' => 4, 'influencer' => 4],
                ['ca_name' => 'Pemkab Serdang Bedagai', 'local_gov' => 3, 'local_partners' => 3, 'national_partners' => 3, 'nap' => 3, 'influencer' => 3],
                ['ca_name' => 'Pemkab Karo', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Batubara', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
            ]),
            'Nama AM 5' => collect([
                ['ca_name' => 'Pemkab Tapanuli Utara', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Toba', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Humbang Hasundutan', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
                ['ca_name' => 'Pemkab Samosir', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
            ]),
            'Nama AM 1' => collect([
                ['ca_name' => 'Pemkot Medan', 'local_gov' => 8, 'local_partners' => 8, 'national_partners' => 8, 'nap' => 8, 'influencer' => 8],
                ['ca_name' => 'Pemkot Siantar', 'local_gov' => 3, 'local_partners' => 3, 'national_partners' => 3, 'nap' => 3, 'influencer' => 3],
                ['ca_name' => 'Pemprov Sumut', 'local_gov' => 3, 'local_partners' => 3, 'national_partners' => 3, 'nap' => 3, 'influencer' => 3],
                ['ca_name' => 'Pemkot Tebing Tinggi', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
            ]),
            'Nama AM 4' => collect([
                ['ca_name' => 'Pemkab Simalungun', 'local_gov' => 3, 'local_partners' => 3, 'national_partners' => 3, 'nap' => 3, 'influencer' => 3],
                ['ca_name' => 'Pemkab Asahan', 'local_gov' => 3, 'local_partners' => 3, 'national_partners' => 3, 'nap' => 3, 'influencer' => 3],
                ['ca_name' => 'Pemkab Labuhanbatu', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Langkat', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
            ]),
            'Nama AM 2' => collect([
                ['ca_name' => 'Pemkab Padang Lawas', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Mandailing Natal', 'local_gov' => 2, 'local_partners' => 2, 'national_partners' => 2, 'nap' => 2, 'influencer' => 2],
                ['ca_name' => 'Pemkab Tapanuli Selatan', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
                ['ca_name' => 'Pemkab Tapanuli Tengah', 'local_gov' => 1, 'local_partners' => 1, 'national_partners' => 1, 'nap' => 1, 'influencer' => 1],
            ]),
        ]);

        $recapData = $rawAmData->map(function ($caGroups) {
            $caMapped = $caGroups->map(function ($row) {
                $visit = $row['local_gov'] + $row['local_partners'] + $row['national_partners'] + $row['nap'] + $row['influencer'];
                $row['visit'] = $visit;
                return $row;
            })->sortByDesc('visit');

            return [
                'ca_groups' => $caMapped,
                'total_am'  => $caMapped->sum('visit'),
            ];
        })->sortByDesc(function ($amData) {
            return $amData['total_am'];
        });

        return view('admin.intimacy-monitoring.dashboard.index', compact('recapData', 'bulan'));
    }

    public function index(Request $request)
    {
        $imports = ActivityImport::query()
            ->latest()
            ->paginate(10);

        return view('admin.intimacy-monitoring.index', [
            'imports' => $imports,
        ]);
    }

    public function preview(Request $request, ActivityImport $import)
    {
        $alreadyImportedQuery = function ($query) {
            $query->selectRaw('1')
                ->from('activities')
                ->whereColumn(
                    'activities.source_id',
                    'activity_import_rows.source_id'
                );
        };

        $totalRows = $import->rows()->count();
        $validRows = $import->rows()->where('validation_status', 'valid')->count();
        $invalidRows = $import->rows()->where('validation_status', 'invalid')->count();
        $emptyRows = $import->rows()->where('validation_status', 'empty')->count();

        $alreadyImportedRows = $import->rows()
            ->where('validation_status', 'valid')
            ->whereNotNull('source_id')
            ->whereExists($alreadyImportedQuery)
            ->count();

        $readyRows = $validRows - $alreadyImportedRows;

        $filter = $request->query('filter', 'all');

        $rowsQuery = $import->rows()
            ->select('activity_import_rows.*')
            ->selectRaw("
            CASE
                WHEN validation_status = 'valid'
                AND source_id IS NOT NULL
                AND EXISTS (
                    SELECT 1
                    FROM activities
                    WHERE activities.source_id = activity_import_rows.source_id
                )
                THEN 1
                ELSE 0
            END AS already_imported
        ");

        switch ($filter) {
            case 'ready':
                $rowsQuery
                    ->where('validation_status', 'valid')
                    ->whereNotNull('source_id')
                    ->whereNotExists($alreadyImportedQuery);
                break;

            case 'already_imported':
                $rowsQuery
                    ->where('validation_status', 'valid')
                    ->whereNotNull('source_id')
                    ->whereExists($alreadyImportedQuery);
                break;

            case 'invalid':
                $rowsQuery->where('validation_status', 'invalid');
                break;

            case 'empty':
                $rowsQuery->where('validation_status', 'empty');
                break;
        }

        $rows = $rowsQuery
            ->orderBy('source_row')
            ->paginate(50)
            ->withQueryString();

        return view('admin.intimacy-monitoring.preview', [
            'import' => $import,
            'rows' => $rows,
            'filter' => $filter,
            'totalRows' => $totalRows,
            'validRows' => $validRows,
            'invalidRows' => $invalidRows,
            'emptyRows' => $emptyRows,
            'alreadyImportedRows' => $alreadyImportedRows,
            'readyRows' => $readyRows,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:51200',
            ],
        ]);

        try {
            $result = $this->activityImportService->import(
                $request->file('file'),
                Auth::id()
            );

            return redirect()
                ->route(
                    'admin.intimacy-monitoring.import.preview',
                    $result['import_id']
                )
                ->with('show_validation_alert', true);

        } catch (RuntimeException $e) {
            return back()->withErrors([
                'file' => $e->getMessage(),
            ]);
        }
    }

    public function confirm(ActivityImport $import)
    {
        try {
            $this->activityImportService->confirm($import);

            return redirect()
                ->route(
                    'admin.intimacy-monitoring.import.preview',
                    $import
                )
                ->with('success', 'Import berhasil dikonfirmasi.');
        } catch (RuntimeException $e) {
            return back()->withErrors([
                'import' => $e->getMessage(),
            ]);
        }
    }
}