<?php

namespace App\Http\Controllers;

use App\Services\Activity\ActivityImportService;
use App\Models\ActivityImport;
use App\Models\Activity;
use App\Services\Activity\ActivityReviewService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            ->appends(request()->query());

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
                ->route('admin.intimacy-monitoring.activities', [
                    'import_id' => $import->id,
                ])
                ->with('show_classification_alert', true);
        } catch (RuntimeException $e) {
            return back()->withErrors([
                'import' => $e->getMessage(),
            ]);
        }
    }

    public function activities(Request $request)
    {
        $selectedImport = null;

        if ($request->filled('import_id')) {
            $selectedImport = ActivityImport::findOrFail(
                $request->integer('import_id')
            );
        }

        /*
         * Base query.
         * Kalau user datang dari batch tertentu,
         * Activity List hanya menampilkan activity dari batch tersebut.
         */
        $baseQuery = Activity::query();

        if ($selectedImport) {
            $baseQuery->where('import_id', $selectedImport->id);
        }


        /*
         * Summary status batch.
         * Ini sengaja dihitung sebelum search/status filter,
         * supaya summary selalu menggambarkan seluruh batch.
         */
        $statusSummary = (clone $baseQuery)
            ->selectRaw('classification_status, COUNT(*) as total')
            ->groupBy('classification_status')
            ->pluck('total', 'classification_status');

        $batchTotal = $statusSummary->sum();


        /*
         * Activity table query.
         */
        $query = (clone $baseQuery)
            ->with([
                'activityEntities.category',
                'activityEntities.entity',
            ]);


        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('source_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('ca_name', 'like', "%{$search}%")
                    ->orWhere('activity_notes', 'like', "%{$search}%");
            });
        }


        // Status filter
        if ($request->filled('status')) {
            $query->where(
                'classification_status',
                $request->status
            );
        }


        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate(
                'activity_start_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'activity_start_date',
                '<=',
                $request->date_to
            );
        }


        /*
         * Prioritaskan activity yang membutuhkan action user.
         */
        $query->orderByRaw("
        CASE classification_status
            WHEN 'review_required' THEN 1
            WHEN 'failed' THEN 2
            WHEN 'pending' THEN 3
            WHEN 'processing' THEN 4
            WHEN 'classified' THEN 5
            WHEN 'no_match' THEN 6
            ELSE 7
        END
    ");

        $query->latest('activity_start_date');


        $activities = $query
            ->paginate(25)
            ->appends($request->query());

        $classificationCompleted = $request->boolean('classification_completed');

        return view('admin.intimacy-monitoring.activities.index', [
            'activities' => $activities,
            'selectedImport' => $selectedImport,
            'statusSummary' => $statusSummary,
            'batchTotal' => $batchTotal,
            'classificationCompleted' => $classificationCompleted,
        ]);
    }

    public function classificationStatus(ActivityImport $import)
    {
        $counts = $import->activities()
            ->selectRaw('classification_status, COUNT(*) as total')
            ->groupBy('classification_status')
            ->pluck('total', 'classification_status');

        $total = $import->activities()->count();

        $pending = (int) ($counts->get('pending', 0));
        $processing = (int) ($counts->get('processing', 0));
        $classified = (int) ($counts->get('classified', 0));
        $reviewRequired = (int) ($counts->get('review_required', 0));
        $noMatch = (int) ($counts->get('no_match', 0));
        $failed = (int) ($counts->get('failed', 0));

        $completed = $classified
            + $reviewRequired
            + $noMatch
            + $failed;

        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'processing' => $processing,
            'classified' => $classified,
            'review_required' => $reviewRequired,
            'no_match' => $noMatch,
            'failed' => $failed,
            'completed' => $completed,
            'remaining' => max(0, $total - $completed),
            'is_complete' => $total > 0 && ($pending + $processing) === 0,
        ]);
    }
    public function reviewClassification(
        Request $request,
        Activity $activity,
        ActivityReviewService $reviewService
    ) {
        $validated = $request->validate([
            'decision' => [
                'required',
                Rule::in(['selected', 'no_match']),
            ],

            'activity_entity_id' => [
                'nullable',
                'integer',
            ],
        ]);

        if (
            $validated['decision'] === 'selected' &&
            empty($validated['activity_entity_id'])
        ) {
            return back()
                ->withErrors([
                    'activity_entity_id' =>
                        'Pilih candidate classification terlebih dahulu.',
                ]);
        }

        $reviewService->review(
            $activity,
            $validated['decision'],
            $validated['activity_entity_id'] ?? null
        );

        return back()->with(
            'review_success',
            $validated['decision'] === 'selected'
            ? 'Classification berhasil dikonfirmasi.'
            : 'Activity  tidak memiliki klasifikasi yang sesuai.'
        );
    }
}