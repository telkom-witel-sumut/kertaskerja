@extends('layouts.app')

@section('title', 'Intimacy Monitoring - Activity List')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- HEADER --}}
        @include('admin.intimacy-monitoring.partials._header', [
            'subtitle' => 'Activity List'
        ])

        {{-- BATCH CONTEXT --}}
        @include('admin.intimacy-monitoring.activities._batch-context')

        {{-- FILTERS --}}
        @include('admin.intimacy-monitoring.activities._filters')

        {{-- ACTIVITY TABLE --}}
        @include('admin.intimacy-monitoring.activities._table')

        {{-- DETAIL MODAL --}}
        @include('admin.intimacy-monitoring.activities._detail-modal')

    </div>
@endsection

@if (request()->boolean('classification_completed'))
    <script>
        const url = new URL(window.location.href);
        url.searchParams.delete('classification_completed');
        window.history.replaceState({}, '', url.toString());
    </script>
@endif