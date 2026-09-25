@extends('layouts.app')

@section('title', 'Pilih Dashboard - Kertas Kerja Management System')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6" style="background:#f1f5f9;">
    <div class="max-w-4xl w-full">
        
        {{-- Header Branding --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Pilih Sistem <span class="text-red-600">Dashboard</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Kertas Kerja Management System</p>
                    </div>
                </div>

                {{-- Tombol Logout di Navbar Kanan --}}
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="inline-flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-black text-xs px-6 py-3 rounded-xl transition-all duration-300 shadow-sm uppercase tracking-wider cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Grid 2 Tombol Pilihan (Khusus Admin) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- OPSI 1: Kertas Kerja Witel --}}
            <a href="{{ route('admin.index') }}" 
               class="group bg-white rounded-2xl border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/15 transition-all duration-300 hover:-translate-y-1.5 overflow-hidden relative flex flex-col justify-between">
                
                <div class="h-1.5 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                    style="background: radial-gradient(ellipse at top right, #fff1f2 0%, transparent 60%);"></div>

                <div class="p-8 relative">
                    <div class="flex items-start justify-between mb-6">
                        <div class="rounded-2xl flex items-center justify-center shadow-sm border-2"
                            style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:60px; height:60px;">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1 uppercase">WITEL</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight group-hover:text-red-600 transition-colors mb-2">Kertas Kerja Witel</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">Kelola data worksheet Scalling, PSAK, Collection Ratio, dan manajemen laporan operasional Witel Sumut.</p>
                </div>

                <div class="p-8 pt-0 relative">
                    <div class="flex items-center justify-between border-t border-slate-100 pt-5">
                        <span class="text-xs font-black text-slate-400 group-hover:text-red-600 uppercase tracking-widest transition-colors duration-200">Akses Modul</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-red-600 flex items-center justify-center transition-all duration-200">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            {{-- OPSI 2: Intimacy Gov --}}
            <a href="{{ route('admin.intimacy-monitoring.dashboard') }}" 
            class="group bg-white rounded-2xl border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/15 transition-all duration-300 hover:-translate-y-1.5 overflow-hidden relative flex flex-col justify-between">
                <div class="h-1.5 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                    style="background: radial-gradient(ellipse at top right, #fff1f2 0%, transparent 60%);"></div>

                <div class="p-8 relative">
                    <div class="flex items-start justify-between mb-6">
                        <div class="rounded-2xl flex items-center justify-center shadow-sm border-2"
                            style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:60px; height:60px;">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1 uppercase">GOV</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight group-hover:text-red-600 transition-colors mb-2">Intimacy Gov</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">Pantau dashboard interaksi, monitoring kunjungan Account Manager, dan klasifikasi aktivitas segmen Government.</p>
                </div>

                <div class="p-8 pt-0 relative">
                    <div class="flex items-center justify-between border-t border-slate-100 pt-5">
                        <span class="text-xs font-black text-slate-400 group-hover:text-red-600 uppercase tracking-widest transition-colors duration-200">Akses Modul</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-red-600 flex items-center justify-center transition-all duration-200">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

        </div>

    </div>
</div>
@endsection