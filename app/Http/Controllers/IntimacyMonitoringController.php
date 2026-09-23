<?php

namespace App\Http\Controllers;

use App\Services\Activity\ActivityImportService;
use App\Models\ActivityImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RuntimeException;
class IntimacyMonitoringController extends Controller
{
    public function index()
    {
        $imports = ActivityImport::query()
            ->latest()
            ->paginate(10);

        return view('admin.intimacy-monitoring.index', [
            'imports' => $imports,
        ]);
    }

    private ActivityImportService $activityImportService;

    public function __construct(ActivityImportService $activityImportService)
    {
        $this->activityImportService = $activityImportService;
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

        // Summary
        $totalRows = $import->rows()->count();

        $validRows = $import->rows()
            ->where('validation_status', 'valid')
            ->count();

        $invalidRows = $import->rows()
            ->where('validation_status', 'invalid')
            ->count();

        $emptyRows = $import->rows()
            ->where('validation_status', 'empty')
            ->count();

        $alreadyImportedRows = $import->rows()
            ->where('validation_status', 'valid')
            ->whereNotNull('source_id')
            ->whereExists($alreadyImportedQuery)
            ->count();

        $readyRows = $validRows - $alreadyImportedRows;

        // Filter
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