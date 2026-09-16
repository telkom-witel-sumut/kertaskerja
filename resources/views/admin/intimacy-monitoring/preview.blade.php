@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Import Preview</h1>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        <div>
            <p><strong>File:</strong> {{ $import->file_name }}</p>
            <p><strong>Total:</strong> {{ $import->total_rows }}</p>
            <p><strong>Valid:</strong> {{ $import->valid_rows }}</p>
            <p><strong>Invalid:</strong> {{ $import->invalid_rows }}</p>
            <p><strong>Processed:</strong> {{ $import->processed_rows }}</p>
            <p><strong>Status:</strong> {{ $import->status }}</p>
        </div>

        @if ($import->status === 'preview')
            <form method="POST" action="{{ route('admin.intimacy-monitoring.import.confirm', $import) }}">
                @csrf

                <button type="submit">
                    Confirm Import
                </button>
            </form>
        @endif
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Excel Row</th>
                    <th>Name</th>
                    <th>Activity Start</th>
                    <th>Activity notes</th>
                    <th>PIC</th>
                    <th>Validation</th>
                    <th>Error</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row->source_row }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->activity_start_date }}</td>
                        <td>{{ $row->activity_notes }}</td>
                        <td>{{ $row->nama_pic_1 }}</td>
                        <td>{{ $row->validation_status }}</td>
                        <td>
                            @if ($row->validation_errors)
                                {{ implode(', ', $row->validation_errors) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $rows->links() }}

    </div>
@endsection