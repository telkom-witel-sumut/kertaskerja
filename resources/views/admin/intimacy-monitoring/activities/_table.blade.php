<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- Table Header --}}
    <div class="px-8 py-6 border-b border-slate-100">

        <div class="flex items-center justify-between">

            <div>
                <h3 class="text-base font-black text-slate-900 uppercase tracking-tight">
                    Activities
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    {{ number_format($activities->total()) }} activity ditemukan.
                </p>
            </div>

            <span class="text-xs font-bold text-slate-400">
                {{ $activities->currentPage() }} / {{ $activities->lastPage() }}
            </span>

        </div>

    </div>


    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        Activity ID
                    </th>

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        AM
                    </th>

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        CA Name
                    </th>

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        Activity Start
                    </th>

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        Activity Type
                    </th>

                    <th
                        class="px-6 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider whitespace-nowrap">
                        Status
                    </th>

                    <th class="px-8 py-4 text-left text-[10px] font-black text-slate-500
                                                                               uppercase tracking-wider">
                        Classification
                    </th>

                </tr>
            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse ($activities as $activity)

                            @php
                                $statusStyles = match ($activity->classification_status) {
                                    'classified' => 'bg-green-50 text-green-700 border-green-200',
                                    'review_required' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'no_match' => 'bg-slate-50 text-slate-500 border-slate-200',
                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                    'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp

                            <tr tabindex="0" role="button" data-activity-id="{{ $activity->id }}" class="activity-row
                                                                    transition-color
                                                                    {{ $activity->classification_status === 'review_required'
                    ? 'bg-amber-50/50 hover:bg-amber-50 border-l-4 border-l-amber-400'
                    : 'hover:bg-slate-50/70'
                                                                        }}
                                                                                    ">

                                {{-- Activity ID --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="font-black text-slate-700">
                                        {{ $activity->source_id }}
                                    </span>
                                </td>


                                {{-- AM --}}
                                <td class="px-6 py-5">
                                    <div class="min-w-[150px]">
                                        <p class="font-bold text-slate-800">
                                            {{ $activity->name ?: '—' }}
                                        </p>

                                        @if ($activity->nik)
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                {{ $activity->nik }}
                                            </p>
                                        @endif
                                    </div>
                                </td>


                                {{-- CA Name --}}
                                <td class="px-6 py-5">
                                    <span class="text-slate-700">
                                        {{ $activity->ca_name ?: '—' }}
                                    </span>
                                </td>


                                {{-- Activity Start --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if ($activity->activity_start_date)

                                        <p class="font-semibold text-slate-700">
                                            {{ $activity->activity_start_date->format('d M Y') }}
                                        </p>

                                        <p class="text-[11px] text-slate-400 mt-1">
                                            {{ $activity->activity_start_date->format('H:i') }}
                                        </p>

                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>


                                {{-- Activity Type --}}
                                <td class="px-6 py-5">
                                    <span class="text-slate-700">
                                        {{ $activity->activity_type ?: '—' }}
                                    </span>
                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-5 whitespace-nowrap">

                                    <span
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg
                                                                                                                                                                                                       border text-[10px] font-black uppercase tracking-wider
                                                                                                                                                                                                       {{ $statusStyles }}">
                                        {{ str_replace('_', ' ', $activity->classification_status ?? 'unknown') }}
                                    </span>

                                </td>


                                {{-- Classification --}}
                                <td class="px-8 py-5">

                                    @if ($activity->activityEntities->isNotEmpty())

                                        <div class="space-y-2 min-w-[240px]">

                                            @foreach ($activity->activityEntities->take(2) as $classification)

                                                <div>
                                                    <p class="text-sm font-bold text-slate-700">
                                                        {{ $classification->category?->name ?? '—' }}
                                                    </p>

                                                    @if ($classification->entity)
                                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                                            {{ $classification->entity->name }}
                                                        </p>
                                                    @endif
                                                </div>

                                            @endforeach


                                            @if ($activity->activityEntities->count() > 2)
                                                <p class="text-[11px] font-bold text-slate-400">
                                                    +{{ $activity->activityEntities->count() - 2 }} more
                                                </p>
                                            @endif

                                        </div>

                                    @else

                                        <span class="text-slate-400">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>

                @empty


                    @php
                        $search = trim((string) request('search'));
                        $status = request('status');

                        if ($search) {
                            $emptyTitle = 'Pencarian tidak ditemukan';
                            $emptyDescription = 'Tidak ada activity yang cocok dengan pencarian "' . $search . '".';
                        } elseif ($status) {
                            $statusLabel = match ($status) {
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'classified' => 'Classified',
                                'review_required' => 'Review Required',
                                'no_match' => 'No Match',
                                'failed' => 'Failed',
                                default => ucfirst(str_replace('_', ' ', $status)),
                            };

                            $emptyTitle = $statusLabel . ' tidak ditemukan';
                            $emptyDescription = 'Tidak ada activity dengan status ' . $statusLabel . ' pada data yang sedang ditampilkan.';
                        } elseif (request('date_from') || request('date_to')) {
                            $from = request('date_from')
                                ? \Carbon\Carbon::parse(request('date_from'))->format('d M Y')
                                : null;

                            $to = request('date_to')
                                ? \Carbon\Carbon::parse(request('date_to'))->format('d M Y')
                                : null;

                            if ($from && $to) {
                                $periodLabel = $from . ' – ' . $to;
                            } elseif ($from) {
                                $periodLabel = 'mulai ' . $from;
                            } else {
                                $periodLabel = 'sampai ' . $to;
                            }

                            $emptyTitle = 'Tidak ada activity pada periode ini';
                            $emptyDescription = 'Tidak ditemukan activity pada rentang ' . $periodLabel . '.';
                        } else {
                            $emptyTitle = 'Belum ada activity';
                            $emptyDescription = 'Belum ada activity yang tersedia pada data yang sedang ditampilkan.';
                        }
                    @endphp

                    <tr>
                        <td colspan="7" class="px-8 py-16 text-center">

                            <div class="flex flex-col items-center">

                                <div
                                    class="w-12 h-12 rounded-xl bg-slate-100
                                                                                                                        text-slate-400 flex items-center justify-center">

                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h6m-6 4h4m5-12h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2" />
                                    </svg>

                                </div>

                                <p class="mt-4 text-sm font-bold text-slate-600">
                                    {{ $emptyTitle }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $emptyDescription }}
                                </p>

                            </div>

                        </td>
                    </tr>

                @endforelse


            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if ($activities->hasPages())
        <div class="px-8 py-5 border-t border-slate-100">
            {{ $activities->links() }}
        </div>
    @endif

</div>