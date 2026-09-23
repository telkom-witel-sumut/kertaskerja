@extends('layouts.app')

@section('title', 'Intimacy Monitoring - Import Preview')

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
                            Import Preview
                        </h1>

                        <p class="text-slate-400 text-xs font-bold mt-1 tracking-tight">
                            Periksa hasil validasi data sebelum import dikonfirmasi.
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">

                    <a href="{{ route('admin.intimacy-monitoring') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900
                                                                           hover:bg-slate-900 text-slate-900 hover:text-white
                                                                           px-6 py-3 rounded-xl font-black text-xs
                                                                           transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>

                        <span>Data Management</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="group flex items-center space-x-2.5
                                                                               bg-slate-900 hover:bg-red-600 text-white
                                                                               font-bold text-sm px-5 py-3 rounded-xl
                                                                               transition-all duration-300 shadow-md
                                                                               hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 013 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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


        {{-- ══ IMPORT SUMMARY ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">

            {{-- File Information --}}
            <div class="px-8 py-6 border-b border-slate-100">
                <div class="flex items-start justify-between gap-6">

                    <div class="min-w-0">
                        <p class="text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase">
                            Imported File
                        </p>

                        <h3 class="mt-1 text-base font-black text-slate-900 truncate">
                            {{ $import->file_name }}
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Batch #{{ $import->id }}
                        </p>
                    </div>


                    {{-- Batch Status --}}
                    <div class="flex-shrink-0">

                        @php
                            $statusStyles = match ($import->status) {
                                'preview' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'completed' => 'bg-green-50 text-green-700 border-green-200',
                                default => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                        @endphp

                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg border
                                                                                 text-[10px] font-black uppercase tracking-wider
                                                                                 {{ $statusStyles }}">
                            {{ str_replace('_', ' ', $import->status) }}
                        </span>

                    </div>

                </div>
            </div>


            {{-- Summary Metrics --}}
            <div class="grid grid-cols-2 md:grid-cols-5 divide-x divide-slate-100">

                {{-- Total --}}
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                        Total Rows
                    </p>

                    <p class="text-2xl font-black text-slate-900 mt-2">
                        {{ number_format($totalRows) }}
                    </p>
                </div>


                {{-- Ready --}}
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-wider">
                        Ready to Import
                    </p>

                    <p class="text-2xl font-black text-blue-700 mt-2">
                        {{ number_format($readyRows) }}
                    </p>
                </div>


                {{-- Already Imported --}}
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-wider">
                        Already Imported
                    </p>

                    <p class="text-2xl font-black text-amber-700 mt-2">
                        {{ number_format($alreadyImportedRows) }}
                    </p>
                </div>


                {{-- Invalid --}}
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-wider">
                        Invalid
                    </p>

                    <p class="text-2xl font-black text-red-700 mt-2">
                        {{ number_format($invalidRows) }}
                    </p>
                </div>


                {{-- Empty --}}
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                        Empty
                    </p>

                    <p class="text-2xl font-black text-slate-600 mt-2">
                        {{ number_format($emptyRows) }}
                    </p>
                </div>

            </div>

        </div>


        {{-- ══ IMPORT RESULT ALERT ══ --}}
@if (session('show_validation_alert'))

    @php
        $hasInvalid = $import->invalid_rows > 0;
        $hasDuplicate = $alreadyImportedRows > 0;
        $hasIssue = $hasInvalid || $hasDuplicate;
    @endphp

    <div
        id="import-result-alert"
        class="mb-8 rounded-2xl border px-6 py-5
            {{ $hasIssue
                ? 'bg-amber-50 border-amber-200'
                : 'bg-green-50 border-green-200'
            }}"
    >
        <div class="flex items-start justify-between gap-4">

            <div class="flex items-start space-x-4">

                {{-- ICON --}}
                <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $hasIssue
                            ? 'bg-amber-100 text-amber-700'
                            : 'bg-green-100 text-green-700'
                        }}"
                >
                    @if ($hasIssue)
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.73-3L13.73 4a2 2 0 00-3.44 0L3.34 16a2 2 0 001.73 3z"
                            />
                        </svg>
                    @else
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    @endif
                </div>


                {{-- MESSAGE --}}
                <div>

                    <p
                        class="text-sm font-black
                            {{ $hasIssue
                                ? 'text-amber-900'
                                : 'text-green-900'
                            }}"
                    >
                        @if ($hasIssue)
                            Import berhasil diproses dengan beberapa catatan.
                        @else
                            Import berhasil diproses.
                        @endif
                    </p>


                    <div
                        class="text-sm mt-1 space-y-1
                            {{ $hasIssue
                                ? 'text-amber-800'
                                : 'text-green-800'
                            }}"
                    >

                        @if ($hasInvalid)
                            <p>
                                {{ number_format($import->invalid_rows) }}
                                row memiliki masalah validasi.
                            </p>
                        @endif

                        @if ($hasDuplicate)
                            <p>
                                {{ number_format($alreadyImportedRows) }}
                                row sudah pernah di-import dan tidak akan membuat Activity baru.
                            </p>
                        @endif

                        @if (!$hasIssue)
                            <p>
                                Tidak ditemukan masalah pada data yang di-upload.
                                Silakan periksa preview sebelum melakukan konfirmasi.
                            </p>
                        @else
                            <p>
                                Periksa detail data pada tabel di bawah sebelum melakukan konfirmasi.
                            </p>
                        @endif

                    </div>

                </div>

            </div>


            {{-- CLOSE --}}
            <button
                type="button"
                onclick="document.getElementById('import-result-alert').remove()"
                class="flex-shrink-0 transition
                    {{ $hasIssue
                        ? 'text-amber-600 hover:text-amber-900'
                        : 'text-green-600 hover:text-green-900'
                    }}"
                aria-label="Tutup notifikasi"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

        </div>
    </div>

@endif

        {{-- ══ ROW PREVIEW ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Table Header --}}
            <div class="px-8 py-6 border-b border-slate-100">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h3 class="text-base font-black text-slate-900 uppercase tracking-tight">
                            Data Preview
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Menampilkan {{ $rows->count() }} row pada halaman ini.
                        </p>
                    </div>

                    <span class="text-xs font-bold text-slate-400 flex-shrink-0">
                        {{ number_format($rows->total()) }} Rows
                    </span>

                </div>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">
                <div class="px-8 py-4 border-b border-slate-100 bg-slate-50/50">

                    <div class="flex items-center justify-between gap-4 flex-wrap">

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">
                                Filter Data
                            </p>

                            <div class="flex items-center gap-2 flex-wrap">

                                @php
                                    $filters = [
                                        'all' => 'All',
                                        'ready' => 'Ready to Import',
                                        'already_imported' => 'Already Imported',
                                        'invalid' => 'Invalid',
                                        'empty' => 'Empty',
                                    ];
                                @endphp

                                @foreach ($filters as $key => $label)

                                                        @php
                                                            $isActive = $filter === $key;

                                                            $url = request()->fullUrlWithQuery([
                                                                'filter' => $key,
                                                                'page' => null,
                                                            ]);
                                                        @endphp

                                                        <a href="{{ $url }}" class="inline-flex items-center px-3 py-2 rounded-lg border text-[10px]
                                                                                                                                               font-black uppercase tracking-wider transition-all
                                                                                                                                               {{ $isActive
                                    ? 'bg-slate-900 border-slate-900 text-white'
                                    : 'bg-white border-slate-200 text-slate-500 hover:border-slate-400 hover:text-slate-800'
                                                                                                                                               }}">
                                                            {{ $label }}

                                                            @if ($key === 'ready')
                                                                <span class="ml-2 opacity-70">
                                                                    {{ number_format($readyRows) }}
                                                                </span>
                                                            @elseif ($key === 'already_imported')
                                                                <span class="ml-2 opacity-70">
                                                                    {{ number_format($alreadyImportedRows) }}
                                                                </span>
                                                            @elseif ($key === 'invalid')
                                                                <span class="ml-2 opacity-70">
                                                                    {{ number_format($invalidRows) }}
                                                                </span>
                                                            @elseif ($key === 'empty')
                                                                <span class="ml-2 opacity-70">
                                                                    {{ number_format($emptyRows) }}
                                                                </span>
                                                            @endif
                                                        </a>

                                @endforeach

                            </div>
                        </div>


                        <div class="text-xs font-bold text-slate-400">
                            {{ number_format($rows->total()) }} Rows
                        </div>

                    </div>

                </div>
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Baris Excel
                            </th>

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Nama AM
                            </th>

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Activity Start
                            </th>

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider">
                                Activity Notes
                            </th>

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                PIC
                            </th>

                            <th
                                class="px-6 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Validasi Status
                            </th>
                            <th class="px-6 py-4 text-left text-[10px] font-black
                       text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                Import Status
                            </th>
                            <th
                                class="px-8 py-4 text-left text-[10px] font-black
                                                                                   text-slate-500 uppercase tracking-wider">
                                Error
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($rows as $row)

                            @php
                                $validationStyles = match ($row->validation_status) {
                                    'valid' => 'bg-green-50 text-green-700 border-green-200',
                                    'invalid' => 'bg-red-50 text-red-700 border-red-200',
                                    'empty' => 'bg-slate-50 text-slate-500 border-slate-200',
                                    'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50/70 transition-colors align-top">

                                {{-- Excel Row --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="font-black text-slate-700">
                                        {{ $row->source_row }}
                                    </span>
                                </td>


                                {{-- Name --}}
                                <td class="px-6 py-5">
                                    <div class="min-w-[180px]">
                                        <p class="font-bold text-slate-800">
                                            {{ $row->name ?: '—' }}
                                        </p>

                                        @if ($row->ca_name)
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                {{ $row->ca_name }}
                                            </p>
                                        @endif
                                    </div>
                                </td>


                                {{-- Activity Start --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if ($row->activity_start_date)
                                        <p class="font-semibold text-slate-700">
                                            {{ $row->activity_start_date->format('d M Y') }}
                                        </p>

                                        <p class="text-[11px] text-slate-400 mt-1">
                                            {{ $row->activity_start_date->format('H:i') }}
                                        </p>
                                    @else
                                        <span class="text-slate-400">
                                            —
                                        </span>
                                    @endif
                                </td>


                                {{-- Activity Notes --}}
                                <td class="px-6 py-5">
                                    <div class="max-w-md min-w-[280px]">
                                        <p class="text-sm leading-6 text-slate-600 whitespace-normal">
                                            {{ $row->activity_notes ?: '—' }}
                                        </p>
                                    </div>
                                </td>


                                {{-- PIC --}}
                                <td class="px-6 py-5">
                                    <div class="min-w-[180px]">

                                        <p class="font-semibold text-slate-700">
                                            {{ $row->nama_pic_1 ?: '—' }}
                                        </p>

                                        @if ($row->jabatan_pic_1)
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                {{ $row->jabatan_pic_1 }}
                                            </p>
                                        @endif

                                    </div>
                                </td>


                                {{-- Validation --}}
                                <td class="px-6 py-5 whitespace-nowrap">

                                    <span
                                        class="inline-flex items-center px-2.5 py-1.5
                                                                                                                                         rounded-lg border text-[10px]
                                                                                                                                         font-black uppercase tracking-wider
                                                                                                                                         {{ $validationStyles }}">
                                        {{ str_replace('_', ' ', $row->validation_status ?: 'unknown') }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">

                                    @if ($row->validation_status === 'invalid')

                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg
                                                     border text-[10px] font-black uppercase tracking-wider
                                                     bg-red-50 text-red-700 border-red-200">
                                            Not Imported
                                        </span>

                                    @elseif ($row->validation_status === 'empty')

                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg
                                                     border text-[10px] font-black uppercase tracking-wider
                                                     bg-slate-50 text-slate-500 border-slate-200">
                                            Skipped
                                        </span>

                                    @elseif ((int) $row->already_imported === 1)

                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg
                                                     border text-[10px] font-black uppercase tracking-wider
                                                     bg-amber-50 text-amber-700 border-amber-200">
                                            Already Imported
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg
                                                     border text-[10px] font-black uppercase tracking-wider
                                                     bg-blue-50 text-blue-700 border-blue-200">
                                            New
                                        </span>

                                    @endif

                                </td>

                                {{-- Error --}}
                                <td class="px-8 py-5">

                                    @if (!empty($row->validation_errors))

                                        <div class="max-w-sm space-y-1.5">

                                            @foreach ($row->validation_errors as $error)
                                                <div class="flex items-start space-x-2">

                                                    <span class="text-red-500 mt-0.5">•</span>

                                                    <p class="text-xs leading-5 text-red-700">
                                                        {{ $error }}
                                                    </p>

                                                </div>
                                            @endforeach

                                        </div>

                                    @else

                                        <span class="text-xs text-slate-400">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

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
                                            Tidak ada data preview
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($rows->hasPages())
                <div class="px-8 py-5 border-t border-slate-100">
                    {{ $rows->links() }}
                </div>
            @endif

        </div>


        {{-- ══ CONFIRMATION AREA ══ --}}
        @if ($import->status === 'preview')

            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="px-8 py-6">

                    <div class="flex items-center justify-between gap-6">

                        <div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight">
                                Confirm Import
                            </h3>

                            <p class="text-xs text-slate-500 mt-1">
                                Pastikan data dan hasil validasi sudah diperiksa sebelum melanjutkan.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('admin.intimacy-monitoring.import.confirm', $import) }}">
                            @csrf

                            <button type="submit"
                                class="inline-flex items-center justify-center space-x-2
                                                                                                                               bg-slate-900 hover:bg-red-600
                                                                                                                               text-white px-7 py-3 rounded-xl
                                                                                                                               font-black text-xs uppercase tracking-wider
                                                                                                                               transition-all duration-300 shadow-md
                                                                                                                               hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>

                                <span>Confirm Import</span>
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        @endif

    </div>
@endsection