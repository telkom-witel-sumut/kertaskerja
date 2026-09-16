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
        return view('admin.intimacy-monitoring.index');
    }

    private ActivityImportService $activityImportService;

    public function __construct(ActivityImportService $activityImportService)
    {
        $this->activityImportService = $activityImportService;
    }

    public function preview(ActivityImport $import)
    {
        $rows = $import->rows()
            ->orderBy('source_row')
            ->paginate(50);

        return view('admin.intimacy-monitoring.preview', [
            'import' => $import,
            'rows' => $rows,
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
                ->with('success', 'File berhasil diproses.');

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