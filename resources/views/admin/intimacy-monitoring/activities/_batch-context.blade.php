@if ($selectedImport)

    @php
        $reviewRequired = (int) $statusSummary->get('review_required', 0);
        $classified = (int) $statusSummary->get('classified', 0);
        $processing = (int) $statusSummary->get('processing', 0);
        $pending = (int) $statusSummary->get('pending', 0);
        $noMatch = (int) $statusSummary->get('no_match', 0);
        $failed = (int) $statusSummary->get('failed', 0);

        $inProgress = $processing + $pending;
        $completed = $batchTotal - $inProgress;
        $progress = $batchTotal > 0
            ? round(($completed / $batchTotal) * 100)
            : 0;

        $showClassificationAlert =
            session('show_classification_alert') ||
            $classificationCompleted;
    @endphp

    {{-- ══ BATCH CONTEXT ══ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6 overflow-hidden">

        <div class="px-8 py-6">

            <div class="flex items-start justify-between gap-6">

                <div class="min-w-0">

                    <p class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">
                        Current Import Batch
                    </p>

                    <div class="flex items-center gap-3 mt-1">

                        <h3 class="text-base font-black text-slate-900 truncate">
                            {{ $selectedImport->file_name }}
                        </h3>

                        <span class="text-xs font-bold text-slate-400">
                            #{{ $selectedImport->id }}
                        </span>

                    </div>

                    <p class="text-xs text-slate-400 mt-1">
                        {{ number_format($batchTotal) }} activities dalam batch ini.
                    </p>

                </div>

                <a href="{{ route('admin.intimacy-monitoring.activities') }}"
                    class="flex-shrink-0 text-xs font-black text-slate-500
                                                                                                                   hover:text-slate-900 transition">
                    View All
                </a>

            </div>


            {{-- Progress --}}
            <div class="mt-5">

                <div class="flex items-center justify-between mb-2">

                    <span id="batch-progress-label" class="text-[10px] font-black text-slate-500 uppercase tracking-wider">
                        {{ $completed }} / {{ $batchTotal }} Processed
                    </span>

                    <span id="batch-progress-percent" class="text-[10px] font-black text-slate-400">
                        {{ $progress }}%
                    </span>

                </div>

                <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">

                    <div id="batch-progress-bar" class="h-full bg-slate-900 rounded-full transition-all duration-500"
                        style="width: {{ $progress }}%;"></div>

                </div>

            </div>


            {{-- Status Summary --}}
            <div class="mt-6 flex flex-wrap gap-3">

                <a id="batch-review-chip" href="{{ route('admin.intimacy-monitoring.activities', [
            'import_id' => $selectedImport->id,
            'status' => 'review_required',
        ]) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                                                                                                   border border-amber-200 bg-amber-50 text-amber-700
                                                                                                                   hover:bg-amber-100 transition">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>

                    <span class="text-[10px] font-black uppercase tracking-wider">
                        Review Required
                    </span>

                    <span id="batch-review-count" class="text-xs font-black">
                        {{ number_format($reviewRequired) }}
                    </span>
                </a>


                <span id="batch-processing-chip"
                    class="{{ $inProgress > 0 ? '' : 'hidden' }}
                                                                                                                   inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                                                                                                   border border-blue-200 bg-blue-50 text-blue-700">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>

                    <span class="text-[10px] font-black uppercase tracking-wider">
                        Processing
                    </span>

                    <span id="batch-processing-count" class="text-xs font-black">
                        {{ number_format($inProgress) }}
                    </span>
                </span>


                <span
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                                                                                                   border border-green-200 bg-green-50 text-green-700">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                    <span class="text-[10px] font-black uppercase tracking-wider">
                        Classified
                    </span>

                    <span id="batch-classified-count" class="text-xs font-black">
                        {{ number_format($classified) }}
                    </span>
                </span>


                <span id="batch-no-match-chip"
                    class="{{ $noMatch > 0 ? '' : 'hidden' }}
                                                                                                                   inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                                                                                                   border border-slate-200 bg-slate-50 text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>

                    <span class="text-[10px] font-black uppercase tracking-wider">
                        No Match
                    </span>

                    <span id="batch-no-match-count" class="text-xs font-black">
                        {{ number_format($noMatch) }}
                    </span>
                </span>


                <span id="batch-failed-chip"
                    class="{{ $failed > 0 ? '' : 'hidden' }}
                                                                                                                   inline-flex items-center gap-2 rounded-lg px-3 py-2
                                                                                                                   border border-red-200 bg-red-50 text-red-700">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>

                    <span class="text-[10px] font-black uppercase tracking-wider">
                        Failed
                    </span>

                    <span id="batch-failed-count" class="text-xs font-black">
                        {{ number_format($failed) }}
                    </span>
                </span>

            </div>

        </div>

    </div>


    {{-- ══ CLASSIFICATION ALERT ══ --}}
    @if ($showClassificationAlert)
        @php
            $isComplete = $inProgress === 0;
        @endphp

        <div id="classification-alert" class="mb-6 rounded-2xl border px-5 py-4
                                                                                                                            {{ $isComplete && $reviewRequired > 0
                    ? 'border-amber-200 bg-amber-50'
                    : ($isComplete
                        ? 'border-emerald-200 bg-emerald-50'
                        : 'border-blue-200 bg-blue-50') }}">
            <div class="flex items-start gap-4">
                <div id="classification-alert-icon" class="mt-0.5 shrink-0">
                    @if ($isComplete && $reviewRequired > 0)
                        <svg class="h-5 w-5 text-amber-600" ...>
                            ...
                        </svg>
                    @elseif ($isComplete)
                        <svg class="h-5 w-5 text-emerald-600" ...>
                            ...
                        </svg>
                    @else
                        <svg class="h-5 w-5 text-blue-600 animate-spin" ...>
                            ...
                        </svg>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <h4 id="classification-alert-title" class="font-semibold
                                                                                                                                        {{ $isComplete && $reviewRequired > 0
                    ? 'text-amber-800'
                    : ($isComplete
                        ? 'text-emerald-800'
                        : 'text-blue-800') }}">
                        @if ($isComplete && $reviewRequired > 0)
                            {{ $reviewRequired }} activity perlu direview
                        @elseif ($isComplete)
                            Classification selesai
                        @else
                            Classification sedang diproses
                        @endif
                    </h4>

                    <p id="classification-alert-description" class="mt-1 text-sm
                                                                                                                                        {{ $isComplete && $reviewRequired > 0
                    ? 'text-amber-700'
                    : ($isComplete
                        ? 'text-emerald-700'
                        : 'text-blue-700') }}">
                        @if ($isComplete && $reviewRequired > 0)
                            Periksa {{ $reviewRequired }} activity.
                        @elseif ($isComplete)
                            Seluruh activity telah selesai diproses.
                        @else
                            Proses klasifikasi sedang berjalan...
                        @endif
                    </p>
                </div>

                <button type="button" onclick="document.getElementById('classification-alert').remove()"
                    class="shrink-0 rounded-lg p-1 text-slate-400 hover:bg-white hover:text-slate-600">
                    ✕
                </button>
            </div>
        </div>
    @endif

    @if ($selectedImport && $inProgress > 0)

        <script>
            (() => {
                const statusUrl = @json(
                    route('admin.intimacy-monitoring.activities.status', $selectedImport)
                );

                const importId = @json($selectedImport->id);

                const progressLabel = document.getElementById('batch-progress-label');
                const progressPercent = document.getElementById('batch-progress-percent');
                const progressBar = document.getElementById('batch-progress-bar');

                const processingChip = document.getElementById('batch-processing-chip');
                const processingCount = document.getElementById('batch-processing-count');

                const reviewCount = document.getElementById('batch-review-count');
                const classifiedCount = document.getElementById('batch-classified-count');
                const noMatchChip = document.getElementById('batch-no-match-chip');
                const noMatchCount = document.getElementById('batch-no-match-count');
                const failedChip = document.getElementById('batch-failed-chip');
                const failedCount = document.getElementById('batch-failed-count');

                const alert = document.getElementById('classification-alert');
                const alertIcon = document.getElementById('classification-alert-icon');
                const alertTitle = document.getElementById('classification-alert-title');
                const alertDescription = document.getElementById('classification-alert-description');

                let polling = true;

                function updateAlert(data) {
                    if (!alert) {
                        return;
                    }

                    if (data.is_complete) {
                        alert.className =
                            'mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-6 py-5';

                        alertIcon.className =
                            'w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0';

                        alertIcon.innerHTML = `
                                                                                                                                            <svg class="w-5 h-5" fill="none"
                                                                                                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                                                <path
                                                                                                                                                    stroke-linecap="round"
                                                                                                                                                    stroke-linejoin="round"
                                                                                                                                                    stroke-width="2"
                                                                                                                                                    d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.73-3l-7.82-13a2 2 0 00-3.44 0L3.34 16a2 2 0 001.73 3z"
                                                                                                                                                />
                                                                                                                                            </svg>
                                                                                                                                        `;

                        if (data.review_required > 0) {
                            alertTitle.className = 'text-sm font-black text-amber-900';
                            alertTitle.textContent =
                                `${data.review_required} activity perlu direview.`;

                            alertDescription.className =
                                'text-sm mt-1 text-amber-800';
                        } else {
                            alert.className =
                                'mb-6 rounded-2xl border border-green-200 bg-green-50 px-6 py-5';

                            alertIcon.className =
                                'w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center flex-shrink-0';

                            alertTitle.className =
                                'text-sm font-black text-green-900';

                            alertTitle.textContent =
                                'Classification selesai.';

                            alertDescription.className =
                                'text-sm mt-1 text-green-800';

                            alertDescription.textContent =
                                'Tidak ada activity yang membutuhkan review.';
                        }

                        return;
                    }

                    if (data.remaining > 0) {
                        alert.className =
                            'mb-6 rounded-2xl border border-blue-200 bg-blue-50 px-6 py-5';

                        alertIcon.className =
                            'w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0';

                        alertTitle.className =
                            'text-sm font-black text-blue-900';

                        alertTitle.textContent =
                            'Classification sedang diproses.';

                        alertDescription.className =
                            'text-sm mt-1 text-blue-800';

                        alertDescription.textContent =
                            `${data.completed} dari ${data.total} activity sudah selesai diproses.`;
                    }
                }

                async function pollClassification() {
                    if (!polling) {
                        return;
                    }

                    try {
                        const response = await fetch(statusUrl, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            cache: 'no-store',
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        const data = await response.json();

                        const progress =
                            data.total > 0
                                ? Math.round((data.completed / data.total) * 100)
                                : 0;

                        if (progressLabel) {
                            progressLabel.textContent =
                                `${data.completed} / ${data.total} Processed`;
                        }

                        if (progressPercent) {
                            progressPercent.textContent = `${progress}%`;
                        }

                        if (progressBar) {
                            progressBar.style.width = `${progress}%`;
                        }

                        if (processingCount) {
                            processingCount.textContent =
                                new Intl.NumberFormat('id-ID').format(
                                    data.pending + data.processing
                                );
                        }

                        if (processingChip) {
                            processingChip.classList.toggle(
                                'hidden',
                                data.pending + data.processing === 0
                            );
                        }

                        if (reviewCount) {
                            reviewCount.textContent =
                                new Intl.NumberFormat('id-ID').format(
                                    data.review_required
                                );
                        }

                        if (classifiedCount) {
                            classifiedCount.textContent =
                                new Intl.NumberFormat('id-ID').format(
                                    data.classified
                                );
                        }

                        if (noMatchCount) {
                            noMatchCount.textContent =
                                new Intl.NumberFormat('id-ID').format(
                                    data.no_match
                                );
                        }

                        if (noMatchChip) {
                            noMatchChip.classList.toggle(
                                'hidden',
                                data.no_match === 0
                            );
                        }

                        if (failedCount) {
                            failedCount.textContent =
                                new Intl.NumberFormat('id-ID').format(
                                    data.failed
                                );
                        }

                        if (failedChip) {
                            failedChip.classList.toggle(
                                'hidden',
                                data.failed === 0
                            );
                        }

                        updateAlert(data);

                        if (data.is_complete) {
                            polling = false;

                            const url = new URL(window.location.href);

                            url.searchParams.set('classification_completed', '1');

                            window.location.href = url.toString();

                            return;
                        }

                    } catch (error) {
                        console.error('Classification polling failed:', error);
                    }

                    if (polling) {
                        setTimeout(pollClassification, 3000);
                    }
                }

                pollClassification();
            })();
        </script>

    @endif
@endif