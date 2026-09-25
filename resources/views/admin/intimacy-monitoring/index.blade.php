@extends('layouts.app')

@section('title', 'Intimacy Monitoring - Data Management')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">

            <div class="absolute top-0 left-0 right-0 h-1.5"
                style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);">
            </div>

            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;">
            </div>

            <div class="relative flex items-center justify-between">

                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">

                    <div class="w-px h-12 bg-slate-200"></div>

                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">
                            Witel Sumut
                        </p>

                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Intimacy <span class="text-red-600">Monitoring</span>
                        </h1>

                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                            Data Management
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">

                    {{-- Tombol Back to Dashboard diarahkan ke dashboard Intimacy --}}
                    <a href="{{ route('admin.intimacy-monitoring.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900
                            hover:bg-slate-900 text-slate-900 hover:text-white
                            px-6 py-3 rounded-xl font-black text-xs
                            transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>

                        <span>Back to Dashboard</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="group flex items-center space-x-2.5
                                bg-slate-900 hover:bg-red-600 text-white
                                font-bold text-sm px-5 py-3 rounded-xl
                                transition-all duration-300 shadow-md
                                hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>

                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>


        {{-- ══ SESSION SUCCESS ══ --}}
        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-800
                                                                                                                                                                                                                                px-5 py-4 rounded-xl flex items-start space-x-3">

                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>

                <div>
                    <p class="font-bold text-sm">
                        Berhasil
                    </p>

                    <p class="text-sm mt-0.5">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif


        {{-- ══ VALIDATION ERROR ══ --}}
        @if ($errors->any())
            <div
                class="mb-6 bg-red-50 border border-red-200 text-red-800
                                                                                                                                                                                                                                px-5 py-4 rounded-xl">

                <div class="flex items-start space-x-3">

                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z" />
                    </svg>

                    <div>
                        <p class="font-bold text-sm">
                            Upload gagal
                        </p>

                        <ul class="mt-1 text-sm space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif


        {{-- ══ IMPORT CARD ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-8 py-6 border-b border-slate-100">
                <div class="flex items-center space-x-3">

                    <div
                        class="w-10 h-10 rounded-xl bg-red-50 text-red-600
                                                                                                                                    flex items-center justify-center">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M12 12v9m0 0l-3-3m3 3l3-3" />
                        </svg>

                    </div>

                    <div>
                        <h3 class="text-base font-black text-slate-900 uppercase tracking-tight">
                            Import Activity Data
                        </h3>

                        <p class="text-xs text-slate-400 mt-0.5">
                            Pilih periode dan upload file Excel untuk memulai proses import.
                        </p>
                    </div>

                </div>
            </div>


            {{-- Card Body --}}
            <div class="px-8 py-8">

                <form action="{{ route('admin.intimacy-monitoring.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-5">

                        {{-- ROW 1: PERIODE + FILE --}}
                        <div class="grid grid-cols-12 gap-5 items-end">

                            {{-- PERIODE --}}
                            <div class="col-span-5">
                                <label for="period"
                                    class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-3">
                                    Periode
                                </label>

                                <input type="month" id="period" name="period" value="{{ old('period') }}" required class="w-full h-12 px-4 bg-slate-50 border border-slate-300
                                                   rounded-xl text-sm text-slate-700 font-semibold
                                                   focus:outline-none focus:ring-2 focus:ring-red-100
                                                   focus:border-red-400 transition" />
                            </div>

                            {{-- FILE --}}
                            <div class="col-span-7">
                                <label for="file"
                                    class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-3">
                                    File Excel
                                </label>

                                <input type="file" id="file" name="file" accept=".xlsx,.xls" required class="block w-full h-12 text-sm text-slate-500
                                                                   border border-slate-300 rounded-xl
                                                                   cursor-pointer bg-slate-50
                                                                   focus:outline-none focus:ring-2
                                                                   focus:ring-red-100 focus:border-red-400
                                                                   file:mr-4 file:h-full file:px-5
                                                                   file:border-0 file:text-xs
                                                                   file:font-black file:bg-slate-100
                                                                   file:text-slate-700
                                                                   hover:file:bg-slate-200
                                                                   file:cursor-pointer" />
                            </div>

                        </div>


                        {{-- ROW 2: ACTION --}}
                        <div class="flex justify-end">

                            <button type="submit" class="h-12 px-7 inline-flex items-center justify-center
                                                               space-x-2 bg-slate-900 hover:bg-red-600
                                                               text-white rounded-xl font-black text-xs
                                                               uppercase tracking-wider
                                                               transition-all duration-300 shadow-md
                                                               hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-125" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>

                                <span>Upload</span>
                            </button>

                        </div>

                    </div>
                    {{-- FILE INFO --}}
                    <div class="mt-4 flex items-center justify-between">

                        <p class="text-xs text-slate-400">
                            Format yang didukung:
                            <span class="font-bold text-slate-500">.xlsx, .xls</span>
                        </p>

                        <p class="text-xs text-slate-400">
                            Maksimal
                            <span class="font-bold text-slate-500">50 MB</span>
                        </p>

                    </div>

                </form>

            </div>

        </div>

        {{-- ══ UPLOAD HISTORY ══ --}}
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Header --}}
            <div class="px-8 py-6 border-b border-slate-100">
                <div class="flex items-center justify-between">

                    <div>
                        <h3 class="text-base font-black text-slate-900 uppercase tracking-tight">
                            Riwayat Upload
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Riwayat file yang pernah diproses pada Intimacy Monitoring.
                        </p>
                    </div>

                    <span class="text-xs font-bold text-slate-400">
                        {{ $imports->total() }} Import
                    </span>

                </div>
            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">

                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                File Name
                            </th>

                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                Periode
                            </th>

                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                Upload Date
                            </th>

                            <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                Total Data
                            </th>

                            <th class="px-8 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-wider">
                                Action
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($imports as $import)

                            <tr class="hover:bg-slate-50/70 transition-colors">

                                {{-- File Name --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">

                                        <div
                                            class="w-9 h-9 rounded-lg bg-green-50 text-green-600
                                                                                                        flex items-center justify-center flex-shrink-0">

                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M4 5a2 2 0 012-2h8l5 5v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" />
                                            </svg>

                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-700 truncate max-w-xs">
                                                {{ $import->file_name }}
                                            </p>

                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                Import #{{ $import->id }}
                                            </p>
                                        </div>

                                    </div>
                                </td>


                                {{-- Periode --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-400">
                                        —
                                    </span>
                                </td>


                                {{-- Upload Date --}}
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="font-semibold text-slate-700">
                                            {{ $import->created_at?->format('d M Y') }}
                                        </p>

                                        <p class="text-[11px] text-slate-400 mt-0.5">
                                            {{ $import->created_at?->format('H:i') }}
                                        </p>
                                    </div>
                                </td>


                                {{-- Total Data --}}
                                <td class="px-6 py-5 text-right">
                                    <span class="font-black text-slate-800">
                                        {{ number_format($import->total_rows) }}
                                    </span>
                                </td>


                                {{-- Action --}}
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-end">

                                        <a href="{{ route('admin.intimacy-monitoring.import.preview', $import) }}"
                                            class="inline-flex items-center space-x-2 px-4 py-2
                                                                                                       rounded-lg border border-slate-300
                                                                                                       text-slate-700 text-xs font-black
                                                                                                       uppercase tracking-wider
                                                                                                       hover:border-slate-900 hover:bg-slate-900
                                                                                                       hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>

                                            <span>View</span>
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">

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
                                            Belum ada riwayat import
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            Upload file Excel untuk membuat batch import pertama.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>


            {{-- Pagination --}}
            @if ($imports->hasPages())
                <div class="px-8 py-5 border-t border-slate-100">
                    {{ $imports->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection