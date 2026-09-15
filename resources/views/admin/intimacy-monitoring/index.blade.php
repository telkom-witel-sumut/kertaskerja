@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Intimacy AM Government Monitoring</h1>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.intimacy-monitoring.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div>
                <label for="file">Upload Excel</label>
                <input
                    type="file"
                    id="file"
                    name="file"
                    accept=".xlsx,.xls"
                    required
                >
            </div>

            <button type="submit">
                Import
            </button>
        </form>
    </div>
@endsection