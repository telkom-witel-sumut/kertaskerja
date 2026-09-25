<div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">

    <form method="GET" action="{{ route('admin.intimacy-monitoring.activities') }}">

        <div class="px-6 py-6">

            <div class="grid grid-cols-12 gap-4 items-end">

                {{-- Search --}}
                <div class="col-span-5">

                    <label for="search" class="block text-[10px] font-black text-slate-500
                                                                           uppercase tracking-wider mb-2">
                        Search
                    </label>

                    <div class="relative">

                        <svg class="absolute left-4 top-1/2 -translate-y-1/2
                                                                               w-4 h-4 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                        </svg>

                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Activity ID, AM, CA Name..." class="w-full h-11 pl-11 pr-4 bg-white border border-slate-300
                                                                               rounded-xl text-sm text-slate-700
                                                                               focus:outline-none focus:ring-2 focus:ring-red-100
                                                                               focus:border-red-400">

                    </div>

                </div>


                {{-- Status --}}
                <div class="col-span-3">

                    <label for="status" class="block text-[10px] font-black text-slate-500
                                       uppercase tracking-wider mb-2">
                        Status
                    </label>

                    <div class="relative">

                        <select id="status" name="status" class="appearance-none w-full h-11 pl-4 pr-10
                                           bg-white border border-slate-200 rounded-xl
                                           text-sm font-semibold text-slate-700
                                           shadow-sm cursor-pointer
                                           hover:border-slate-300
                                           focus:outline-none focus:ring-2 focus:ring-red-100
                                           focus:border-red-400 transition-all duration-200">
                            <option value="">All Status</option>

                            <option value="pending" @selected(request('status') === 'pending')>
                                Pending
                            </option>

                            <option value="processing" @selected(request('status') === 'processing')>
                                Processing
                            </option>

                            <option value="classified" @selected(request('status') === 'classified')>
                                Classified
                            </option>

                            <option value="review_required" @selected(request('status') === 'review_required')>
                                Review Required
                            </option>

                            <option value="no_match" @selected(request('status') === 'no_match')>
                                No Match
                            </option>

                            <option value="failed" @selected(request('status') === 'failed')>
                                Failed
                            </option>
                        </select>

                        {{-- Custom Arrow --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0
                                           flex items-center pr-4 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m6 9 6 6 6-6" />
                            </svg>
                        </div>

                    </div>

                </div>


                {{-- Date From --}}
                <div class="col-span-2">

                    <label for="date_from" class="block text-[10px] font-black text-slate-500
                                                                           uppercase tracking-wider mb-2">
                        From
                    </label>

                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full h-11 px-3 bg-slate-50 border border-slate-300
                                                                           rounded-xl text-sm text-slate-700
                                                                           focus:outline-none focus:ring-2 focus:ring-red-100
                                                                           focus:border-red-400">

                </div>


                {{-- Date To --}}
                <div class="col-span-2">

                    <label for="date_to" class="block text-[10px] font-black text-slate-500
                                                                           uppercase tracking-wider mb-2">
                        To
                    </label>

                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full h-11 px-3 bg-slate-50 border border-slate-300
                                                                           rounded-xl text-sm text-slate-700
                                                                           focus:outline-none focus:ring-2 focus:ring-red-100
                                                                           focus:border-red-400">

                </div>

            </div>


            <div class="mt-4 flex justify-end">

                <button type="submit" class="h-10 px-5 inline-flex items-center space-x-2
                                                                       bg-slate-900 hover:bg-red-600 text-white
                                                                       rounded-lg font-black text-xs uppercase tracking-wider
                                                                       transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                    </svg>

                    <span>Apply Filter</span>
                </button>

                @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                    <a href="{{ route('admin.intimacy-monitoring.activities') }}"
                        class="ml-2 h-10 px-5 inline-flex items-center
                                                                                                                   rounded-lg border border-slate-300
                                                                                                                   text-slate-600 hover:bg-slate-50
                                                                                                                   font-black text-xs uppercase tracking-wider
                                                                                                                   transition-all">
                        Reset
                    </a>
                @endif

            </div>

        </div>
    </form>
</div>