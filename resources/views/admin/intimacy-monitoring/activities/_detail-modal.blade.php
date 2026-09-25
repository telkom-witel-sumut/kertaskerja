{{-- ══ ACTIVITY DETAIL MODAL ══ --}}
<div id="activity-modal" class="fixed inset-0 z-[60] hidden" aria-hidden="true">
    {{-- Backdrop --}}
    <div id="activity-modal-backdrop" class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    {{-- Modal --}}
    <div class="relative flex items-center justify-center min-h-screen px-4 py-8">

        <div id="activity-modal-panel" class="relative w-full max-w-5xl max-h-[90vh] bg-white rounded-2xl
                   shadow-2xl overflow-hidden flex flex-col" role="dialog" aria-modal="true"
            aria-labelledby="activity-modal-title">

            {{-- ══ MODAL HEADER ══ --}}
            <div class="px-8 py-6 border-b border-slate-200 flex items-start justify-between gap-6">

                <div>
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em]">
                        Activity Detail
                    </p>

                    <h2 id="activity-modal-title" class="text-xl font-black text-slate-900 mt-1">
                        Detail Aktivitas AM
                    </h2>

                    <p id="activity-modal-subtitle" class="text-xs text-slate-400 mt-1"></p>
                </div>

                <button type="button" id="activity-modal-close" class="w-9 h-9 rounded-lg text-slate-400 hover:text-slate-700
                           hover:bg-slate-100 transition flex items-center justify-center"
                    aria-label="Tutup detail aktivitas">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>


            {{-- ══ MODAL BODY ══ --}}
            <div class="overflow-y-auto">

                <div class="p-8 space-y-8">

                    {{-- ══ ACCOUNT MANAGER + ACTIVITY ══ --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- ACCOUNT MANAGER --}}
                        <div>

                            <h3 class="text-[10px] font-black text-slate-400
                                       uppercase tracking-[0.15em] mb-4">
                                Account Manager
                            </h3>

                            <div class="space-y-4">

                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">
                                        Nama AM
                                    </p>

                                    <p id="modal-name" class="text-sm font-bold text-slate-800 mt-1">
                                        —
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            NIK
                                        </p>

                                        <p id="modal-nik" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            AM Type
                                        </p>

                                        <p id="modal-am-type" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                </div>

                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            Segment
                                        </p>

                                        <p id="modal-segment" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            Division
                                        </p>

                                        <p id="modal-division" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                </div>

                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            Regional
                                        </p>

                                        <p id="modal-regional" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            Witel
                                        </p>

                                        <p id="modal-witel" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ACTIVITY --}}
                        <div>

                            <h3 class="text-[10px] font-black text-slate-400
                                       uppercase tracking-[0.15em] mb-4">
                                Activity & Customer
                            </h3>

                            <div class="space-y-4">

                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">
                                        Customer Account
                                    </p>

                                    <p id="modal-ca-name" class="text-sm font-bold text-slate-800 mt-1">
                                        —
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            NIPNAS
                                        </p>

                                        <p id="modal-nipnas" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">
                                            Activity Type
                                        </p>

                                        <p id="modal-activity-type" class="text-sm text-slate-700 mt-1">
                                            —
                                        </p>
                                    </div>

                                </div>

                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">
                                        Label Kunjungan
                                    </p>

                                    <p id="modal-label" class="text-sm text-slate-700 mt-1">
                                        —
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">
                                        Waktu Kunjungan
                                    </p>

                                    <p id="modal-activity-start" class="text-sm text-slate-700 mt-1">
                                        —
                                    </p>
                                </div>

                                <div id="modal-end-wrapper" class="hidden">

                                    <p class="text-[10px] font-bold text-slate-400 uppercase">
                                        Waktu Selesai
                                    </p>

                                    <p id="modal-activity-end" class="text-sm text-slate-700 mt-1">
                                        —
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ══ PIC ══ --}}
                    <div class="pt-6 border-t border-slate-100">

                        <h3 class="text-[10px] font-black text-slate-400
                                   uppercase tracking-[0.15em] mb-4">
                            Person in Charge
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Nama PIC
                                </p>

                                <p id="modal-pic-name" class="text-sm font-bold text-slate-800 mt-1">
                                    —
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Jabatan
                                </p>

                                <p id="modal-pic-role" class="text-sm text-slate-700 mt-1">
                                    —
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Peran
                                </p>

                                <p id="modal-pic-position" class="text-sm text-slate-700 mt-1">
                                    —
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- ══ RAW ACTIVITY NOTES ══ --}}
                    <div class="pt-6 border-t border-slate-100">

                        <h3 class="text-[10px] font-black text-slate-400
                                   uppercase tracking-[0.15em] mb-4">
                            Activity Notes
                        </h3>

                        <div class="bg-slate-50 border border-slate-200 rounded-xl px-5 py-4">

                            <p id="modal-notes" class="text-sm leading-6 text-slate-700 whitespace-pre-line">
                                —
                            </p>

                        </div>

                    </div>


                    {{-- ══ CLASSIFICATION ══ --}}
                    <div class="pt-6 border-t border-slate-100">

                        <div class="flex items-center justify-between mb-5">

                            <div>
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">
                                    Classification
                                </h3>

                                <p id="modal-classification-heading" class="text-xs text-slate-400 mt-1">
                                    —
                                </p>
                            </div>

                            <span id="modal-status" class="inline-flex items-center px-3 py-1.5 rounded-lg
                   border text-[10px] font-black uppercase tracking-wider">
                                —
                            </span>

                        </div>

                        <div id="modal-classification-notice" class="hidden mb-4"></div>
                        <div id="modal-classifications" class="space-y-3"></div>
                        <div id="modal-review-actions" class="hidden mt-5 pt-5 border-t border-amber-200"
                            data-route-template="{{ route(
    'admin.intimacy-monitoring.activities.review',
    ['activity' => '__ACTIVITY_ID__']
) }}">
                            <form id="classification-review-form" method="POST">
                                @csrf

                                <input type="hidden" name="decision" id="modal-review-decision">

                                <input type="hidden" name="activity_entity_id" id="modal-review-entity-id">

                                <div>
                                    <p class="text-sm font-black text-slate-800">
                                        Konfirmasi:
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Pilih salah satu kandidat sebagai hasil klasifikasi.
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-3 mt-4">
                                    <button type="submit" id="modal-review-confirm" disabled class="inline-flex items-center justify-center px-4 py-2.5
                       rounded-xl bg-slate-900 text-white
                       text-xs font-black
                       disabled:opacity-40 disabled:cursor-not-allowed
                       hover:bg-slate-800 transition">
                                        Konfirmasi Pilihan
                                    </button>

                                    <button type="button" id="modal-review-no-match" class="inline-flex items-center justify-center px-4 py-2.5
                       rounded-xl border border-slate-200
                       text-slate-600 text-xs font-black
                       hover:bg-slate-50 transition">
                                        Tidak Ada yang Sesuai
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>


                    {{-- ══ SOURCE METADATA ══ --}}
                    <div class="pt-6 border-t border-slate-100">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Activity ID
                                </p>

                                <p id="modal-source-id" class="text-sm font-bold text-slate-700 mt-1">
                                    —
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Import Batch
                                </p>

                                <p id="modal-import-id" class="text-sm text-slate-700 mt-1">
                                    —
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">
                                    Source Row
                                </p>

                                <p id="modal-source-row" class="text-sm text-slate-700 mt-1">
                                    —
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


{{-- ══ MODAL SCRIPT ══ --}}
@php
    $activityModalData = $activities->getCollection()
        ->mapWithKeys(function ($activity) {
            return [
                (string) $activity->id => [
                    'source_id' => $activity->source_id,
                    'import_id' => $activity->import_id,
                    'source_row' => $activity->source_row,

                    'name' => $activity->name,
                    'nik' => $activity->nik,
                    'am_type' => $activity->am_type,
                    'division' => $activity->division,
                    'segment' => $activity->segment,
                    'regional' => $activity->regional,
                    'witel' => $activity->witel,

                    'ca_name' => $activity->ca_name,
                    'nipnas' => $activity->nipnas,
                    'activity_start_date' => $activity->activity_start_date?->format('d M Y, H:i'),
                    'activity_end_date' => $activity->activity_end_date?->format('d M Y, H:i'),

                    'label' => $activity->label,
                    'activity_type' => $activity->activity_type,
                    'activity_notes' => $activity->activity_notes,

                    'nama_pic_1' => $activity->nama_pic_1,
                    'jabatan_pic_1' => $activity->jabatan_pic_1,
                    'peran_pic_1' => $activity->peran_pic_1,

                    'classification_status' => $activity->classification_status,

                    'classifications' => $activity->activityEntities
                        ->map(function ($classification) {
                            return [
                                'id' => $classification->id,
                                'category' => $classification->category?->name,
                                'entity' => $classification->entity?->name,
                                'match_score' => $classification->match_score,
                                'match_method' => $classification->match_method,
                            ];
                        })
                        ->values()
                        ->all(),
                ],
            ];
        })
        ->all();
@endphp

<script>

    const activityModalData = {{ Illuminate\Support\Js::from($activityModalData) }};

    const activityModal = document.getElementById('activity-modal');
    const activityModalBackdrop = document.getElementById('activity-modal-backdrop');
    const activityModalClose = document.getElementById('activity-modal-close');

    const reviewActions =
        document.getElementById('modal-review-actions');

    const reviewForm =
        document.getElementById('classification-review-form');

    const reviewDecision =
        document.getElementById('modal-review-decision');

    const reviewEntityId =
        document.getElementById('modal-review-entity-id');

    const reviewConfirm =
        document.getElementById('modal-review-confirm');

    const reviewNoMatch =
        document.getElementById('modal-review-no-match');

    function setModalText(id, value) {
        const element = document.getElementById(id);

        if (element) {
            element.textContent = value || '—';
        }
    }

    function getStatusStyle(status) {
        switch (status) {
            case 'classified':
                return 'bg-green-50 text-green-700 border-green-200';

            case 'review_required':
                return 'bg-amber-50 text-amber-700 border-amber-200';

            case 'no_match':
                return 'bg-slate-50 text-slate-500 border-slate-200';

            case 'failed':
                return 'bg-red-50 text-red-700 border-red-200';

            case 'processing':
                return 'bg-blue-50 text-blue-700 border-blue-200';

            default:
                return 'bg-slate-50 text-slate-600 border-slate-200';
        }
    }
    function openActivityModal(activityId) {

        const key = String(activityId);

        const activity = activityModalData[key];


        if (!activity) {
            console.error('STOP: activity tidak ditemukan');
            console.log('Available IDs:', Object.keys(activityModalData));
            return;
        }

        if (!activityModal) {
            console.error('STOP: #activity-modal tidak ditemukan');
            return;
        }

        setModalText('modal-name', activity.name);
        setModalText('modal-nik', activity.nik);
        setModalText('modal-am-type', activity.am_type);
        setModalText('modal-segment', activity.segment);
        setModalText('modal-division', activity.division);
        setModalText('modal-regional', activity.regional);
        setModalText('modal-witel', activity.witel);

        setModalText('modal-ca-name', activity.ca_name);
        setModalText('modal-nipnas', activity.nipnas);
        setModalText('modal-activity-type', activity.activity_type);
        setModalText('modal-label', activity.label);
        setModalText('modal-activity-start', activity.activity_start_date);

        setModalText('modal-pic-name', activity.nama_pic_1);
        setModalText('modal-pic-role', activity.jabatan_pic_1);
        setModalText('modal-pic-position', activity.peran_pic_1);

        setModalText('modal-notes', activity.activity_notes);

        setModalText('modal-source-id', activity.source_id);
        setModalText('modal-import-id', `#${activity.import_id}`);
        setModalText('modal-source-row', activity.source_row);


        const endWrapper = document.getElementById('modal-end-wrapper');


        if (endWrapper) {
            if (activity.activity_end_date) {
                setModalText('modal-activity-end', activity.activity_end_date);
                endWrapper.classList.remove('hidden');
            } else {
                endWrapper.classList.add('hidden');
            }
        }

        const statusElement = document.getElementById('modal-status');

        if (!statusElement) {
            console.error('STOP: #modal-status tidak ditemukan');
            return;
        }

        statusElement.className =
            'inline-flex items-center px-3 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-wider ' +
            getStatusStyle(activity.classification_status);

        statusElement.textContent =
            (activity.classification_status || 'unknown').replaceAll('_', ' ');

        const classificationHeading =
            document.getElementById('modal-classification-heading');

        if (!classificationHeading) {
            console.error('STOP: #modal-classification-heading tidak ditemukan');
            return;
        }

        switch (activity.classification_status) {
            case 'classified':
                classificationHeading.textContent =
                    'Hasil klasifikasi yang terdeteksi.';
                break;

            case 'review_required':
                classificationHeading.textContent =
                    'Verifikasi dibutuhkan.';
                break;

            case 'no_match':
                classificationHeading.textContent =
                    'Tidak ditemukan hasil klasifikasi yang sesuai.';
                break;

            case 'processing':
                classificationHeading.textContent =
                    'Klasifikasi sedang diproses.';
                break;

            case 'failed':
                classificationHeading.textContent =
                    'Klasifikasi gagal diproses.';
                break;

            default:
                classificationHeading.textContent =
                    'Belum ada hasil klasifikasi.';
        }

        // Classification

        const classificationContainer =
            document.getElementById('modal-classifications');

        const classificationNotice =
            document.getElementById('modal-classification-notice');


        if (reviewActions && reviewForm) {
            reviewActions.classList.add('hidden');
            reviewEntityId.value = '';
            reviewDecision.value = '';
            reviewConfirm.disabled = true;

            const routeTemplate =
                reviewActions.dataset.routeTemplate;

            reviewForm.action =
                routeTemplate.replace(
                    '__ACTIVITY_ID__',
                    activityId
                );
        }

        if (!classificationContainer || !classificationNotice) {
            console.error('Element classification modal tidak lengkap.');
            return;
        }

        if (
            !reviewActions ||
            !reviewForm ||
            !reviewDecision ||
            !reviewEntityId ||
            !reviewConfirm ||
            !reviewNoMatch
        ) {
            console.error('Element review modal tidak lengkap.');
            return;
        }

        classificationContainer.innerHTML = '';
        classificationNotice.innerHTML = '';
        classificationNotice.classList.add('hidden');


        // Classification notice
        if (activity.classification_status === 'review_required') {
            classificationNotice.innerHTML = `
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 shrink-0 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-black text-amber-900">
                        Perlu pemeriksaan manual
                    </p>

                    <p class="text-sm text-amber-800 mt-1 leading-6">
                        Classifier menemukan kandidat classification yang belum
                        cukup pasti. Periksa kandidat di bawah sebelum hasil
                        dianggap final.
                    </p>
                </div>
            </div>
        </div>
    `;

            classificationNotice.classList.remove('hidden');
        }


        if (
            activity.classifications &&
            activity.classifications.length > 0
        ) {
            activity.classifications.forEach((classification, index) => {

                const wrapper =
                    activity.classification_status === 'review_required'
                        ? document.createElement('button')
                        : document.createElement('div');

                if (activity.classification_status === 'review_required') {
                    wrapper.type = 'button';

                    wrapper.className =
                        'w-full text-left border border-amber-200 bg-amber-50/50 ' +
                        'rounded-xl px-5 py-4 transition ' +
                        'hover:border-amber-400 hover:bg-amber-50';

                    wrapper.dataset.reviewCandidate = classification.id;
                }
                else {
                    wrapper.className =
                        'border border-slate-200 rounded-xl px-5 py-4';
                }


                // Candidate label
                const candidateLabel = document.createElement('p');

                candidateLabel.className =
                    'text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]';

                candidateLabel.textContent =
                    `Candidate ${index + 1}`;

                wrapper.appendChild(candidateLabel);


                // Category
                const category = document.createElement('p');

                category.className =
                    'text-sm font-black text-slate-800 mt-2';

                category.textContent =
                    classification.category || '—';

                wrapper.appendChild(category);


                // Entity
                const entity = document.createElement('p');

                entity.className =
                    'text-xs text-slate-500 mt-1';

                entity.textContent =
                    classification.entity
                        ? classification.entity
                        : 'Tidak ada entity spesifik';

                wrapper.appendChild(entity);


                // Metadata
                const metadata = document.createElement('div');

                metadata.className =
                    'flex flex-wrap items-center gap-x-5 gap-y-2 mt-4 pt-3 border-t border-slate-100';


                if (classification.match_score !== null) {
                    const score = document.createElement('span');

                    score.className =
                        activity.classification_status === 'review_required'
                            ? 'inline-flex items-center px-2.5 py-1 rounded-md bg-amber-100 text-amber-800 text-[11px] font-bold'
                            : 'inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[11px] font-bold';

                    const scorePercent =
                        Number(classification.match_score) * 100;

                    score.textContent =
                        `Match Score ${scorePercent.toFixed(1)}%`;

                    metadata.appendChild(score);
                }


                if (classification.match_method) {
                    const method = document.createElement('span');

                    method.className =
                        'text-[11px] font-bold text-slate-400';

                    method.textContent =
                        `Method: ${classification.match_method}`;

                    metadata.appendChild(method);
                }

                wrapper.appendChild(metadata);

                if (
                    activity.classification_status === 'review_required' &&
                    classification.id
                ) {
                    wrapper.addEventListener('click', () => {

                        document
                            .querySelectorAll('[data-review-candidate]')
                            .forEach((candidate) => {
                                candidate.classList.remove(
                                    'ring-2',
                                    'ring-amber-500',
                                    'border-amber-500'
                                );

                                candidate.setAttribute(
                                    'aria-pressed',
                                    'false'
                                );
                            });

                        wrapper.classList.add(
                            'ring-2',
                            'ring-amber-500',
                            'border-amber-500'
                        );

                        wrapper.setAttribute(
                            'aria-pressed',
                            'true'
                        );

                        reviewEntityId.value = classification.id;
                        reviewDecision.value = 'selected';
                        reviewConfirm.disabled = false;
                    });
                }

                classificationContainer.appendChild(wrapper);
            });

        } else {

            const empty = document.createElement('div');

            empty.className =
                'bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-sm text-slate-500';

            let message = 'Belum ada hasil klasifikasi.';

            if (activity.classification_status === 'no_match') {
                message = 'Tidak ditemukan hasil classification yang sesuai.';
            }

            if (activity.classification_status === 'processing') {
                message = 'Hasil classification masih diproses.';
            }

            if (activity.classification_status === 'failed') {
                message = 'Hasil classification gagal diproses.';
            }

            if (activity.classification_status === 'review_required') {
                message = 'Classifier meminta pemeriksaan manual, tetapi kandidat classification tidak tersedia.';
            }

            empty.textContent = message;

            classificationContainer.appendChild(empty);
        }

        if (activity.classification_status === 'review_required') {
            reviewActions.classList.remove('hidden');
        }

        activityModal.classList.remove('hidden');
        activityModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        if (activityModalClose) {
            activityModalClose.focus();
        }
    }

    if (reviewNoMatch) {
        reviewNoMatch.addEventListener('click', () => {
            const confirmed = window.confirm(
                'Hasil klasifikasi activity tidak ada yang sesuai?'
            );

            if (!confirmed) {
                return;
            }

            reviewDecision.value = 'no_match';
            reviewEntityId.value = '';

            reviewForm.submit();
        });
    }

    function closeActivityModal() {
        activityModal.classList.add('hidden');
        activityModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }


    document.addEventListener('click', (event) => {
        const row = event.target.closest('.activity-row');

        if (!row) {
            return;
        }

        openActivityModal(row.dataset.activityId);
    });


    document.addEventListener('keydown', (event) => {
        const row = event.target.closest('.activity-row');

        if (!row) {
            return;
        }

        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();

            const activityId = row.dataset.activityId;

            if (!activityId) {
                console.warn('Activity row tidak memiliki data-activity-id.', row);
                return;
            }

            openActivityModal(activityId);
        }
    });


    if (activityModalClose) {
        activityModalClose.addEventListener('click', closeActivityModal);
    }

    if (activityModalBackdrop) {
        activityModalBackdrop.addEventListener('click', closeActivityModal);
    }


    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape' &&
            activityModal &&
            !activityModal.classList.contains('hidden')
        ) {
            closeActivityModal();
        }
    });
</script>