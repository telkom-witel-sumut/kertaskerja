@extends('layouts.app')

@section('title', 'Intimacy AM Gov Dashboard - Kertas Kerja Management System')

@section('content')
    <div class="min-h-screen" style="background:#f1f5f9;">
        <div class="max-w-7xl mx-auto px-8 py-10">

            {{-- SECTION: HEADER NAVBAR --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5"
                    style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
                <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div>
                            <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                            <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Intimacy AM <span class="text-red-600">Gov</span></h1>
                            <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Monitoring & Activity Dashboard</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <form method="GET" action="{{ route('admin.intimacy-monitoring.dashboard') }}" class="inline-flex">
                            <div class="relative inline-block">
                                <select name="bulan" onchange="this.form.submit()"
                                    class="appearance-none bg-white border-2 border-slate-900 hover:border-red-600 text-slate-900 font-black text-xs px-6 py-3 pr-10 rounded-xl focus:outline-none transition-all duration-300 shadow-sm cursor-pointer uppercase tracking-wider">
                                    @php
                                        $bulanNames = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                        $currentBulan = request('bulan', date('n'));
                                    @endphp
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $currentBulan == $m ? 'selected' : '' }}>
                                            {{ strtoupper($bulanNames[$m]) }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </form>

                        <a href="#"
                            class="flex items-center space-x-2 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-5 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                            <svg class="w-4 h-4 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Download Report</span>
                        </a>

                        <a href="{{ route('admin.intimacy-monitoring') }}"
                            class="flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-md shadow-red-200 uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Upload Excel</span>
                        </a>

                        <a href="{{ route('dashboard.select') }}"
                            class="flex items-center space-x-2 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-5 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Menu</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- SECTION: TABEL REKAPITULASI --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-10">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 uppercase tracking-tight">Rekapitulasi Aktivitas Account Manager</h3>
                        <p class="text-xs text-slate-400 font-bold mt-0.5">Menampilkan data rekap per AM dan segmen Government</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 rounded-full px-4 py-1.5">
                        Data Aktual Berdasarkan Upload
                    </span>
                </div>

                <div class="max-h-[420px] overflow-y-auto relative">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-slate-100 text-slate-700 uppercase text-[11px] font-black tracking-wider z-10 border-b border-slate-200 shadow-sm">
                            <tr>
                                <th class="py-4 px-6 text-center w-36">Nama AM</th>
                                <th class="py-4 px-6">CA Name</th>
                                <th class="py-4 px-4 text-center">Local Gov</th>
                                <th class="py-4 px-4 text-center">Local Partners</th>
                                <th class="py-4 px-4 text-center">National Partners</th>
                                <th class="py-4 px-4 text-center">NAP</th>
                                <th class="py-4 px-4 text-center">Influencer</th>
                                <th class="py-4 px-4 text-center">Visit</th>
                                <th class="py-4 px-6 text-center w-28">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                            @forelse($recapData as $amName => $amData)
                                @php
                                    $caGroups = $amData['ca_groups'];
                                    // Ubah ke count() versi PHP agar aman jika bentuknya array
                                    $rowCount = count($caGroups);
                                    $totalPerAm = collect($caGroups)->sum('visit');
                                @endphp

                                @foreach($caGroups as $index => $row)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        @if($index === 0)
                                            <td rowspan="{{ $rowCount }}" class="py-4 px-6 text-center font-bold text-slate-900 bg-slate-50/50 border-r border-slate-100 align-middle">
                                                {{ $amName ?: '—' }}
                                            </td>
                                        @endif

                                        <td class="py-4 px-6 font-semibold text-slate-800">{{ $row['ca_name'] ?: '—' }}</td>
                                        <td class="py-4 px-4 text-center text-slate-600">{{ $row['local_gov'] > 0 ? $row['local_gov'] : '—' }}</td>
                                        <td class="py-4 px-4 text-center text-slate-600">{{ $row['local_partners'] > 0 ? $row['local_partners'] : '—' }}</td>
                                        <td class="py-4 px-4 text-center text-slate-600">{{ $row['national_partners'] > 0 ? $row['national_partners'] : '—' }}</td>
                                        <td class="py-4 px-4 text-center text-slate-600">{{ $row['nap'] > 0 ? $row['nap'] : '—' }}</td>
                                        <td class="py-4 px-4 text-center text-slate-600">{{ $row['influencer'] > 0 ? $row['influencer'] : '—' }}</td>
                                        <td class="py-4 px-4 text-center font-bold text-slate-900">{{ $row['visit'] > 0 ? $row['visit'] : '—' }}</td>

                                        @if($index === 0)
                                            <td rowspan="{{ $rowCount }}" class="py-4 px-6 text-center font-black text-base text-red-600 bg-slate-50/50 border-l border-slate-100 align-middle">
                                                {{ $totalPerAm }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="9" class="py-12 text-center text-slate-400 font-semibold">
                                        Belum ada data aktivitas yang di-upload atau dikonfirmasi untuk bulan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SECTION: KARTU STATISTIK UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'all']) }}" class="group bg-white rounded-2xl p-6 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 group-hover:text-red-600 uppercase mb-2 transition-colors">Total Activity</p>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight">210</h4>
                    <p class="text-xs font-bold text-slate-600 mt-1">Visits</p>
                    <p class="text-xs text-slate-400 font-medium">Kab/Kota</p>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'local_gov']) }}" class="group bg-white rounded-2xl p-6 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 group-hover:text-red-600 uppercase mb-2 transition-colors">Local Gov</p>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight">42</h4>
                    <p class="text-xs font-bold text-slate-600 mt-1">(20% of visits)</p>
                    <p class="text-xs text-slate-400 font-medium truncate">Top: Kadis, Gubsu</p>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'influencer']) }}" class="group bg-white rounded-2xl p-6 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 group-hover:text-red-600 uppercase mb-2 transition-colors">Influencer</p>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight">42</h4>
                    <p class="text-xs font-bold text-slate-600 mt-1">(20% of visits)</p>
                    <p class="text-xs text-slate-400 font-medium">&nbsp;</p>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'partner']) }}" class="group bg-white rounded-2xl p-6 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 group-hover:text-red-600 uppercase mb-2 transition-colors">Partner</p>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight">126</h4>
                    <p class="text-xs font-bold text-slate-600 mt-1">(60% of visits)</p>
                    <p class="text-xs text-slate-400 font-medium truncate">Top: Local SI</p>
                </a>
            </div>

            {{-- SECTION: KARTU PECAHAN ENGAGEMENT --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'eksekutif']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">Eksekutif</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">20 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'ppk']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">PPK</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">14 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'teknis']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">Teknis</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">8 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'influencer_pill']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">Influencer</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">42 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'national_si']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">National SI</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">86 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.intimacy-monitoring.dashboard', ['filter' => 'local_si']) }}" class="group bg-white rounded-full px-8 py-5 border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 flex items-center justify-between relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300 absolute top-0 left-0 right-0"></div>
                    <div>
                        <p class="text-xs font-black tracking-wider text-slate-400 group-hover:text-red-600 uppercase transition-colors">Local SI</p>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">40 <span class="text-xs font-bold text-slate-500">Visits</span></span>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-400 group-hover:text-white flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>

        </div>
    </div>
@endsection