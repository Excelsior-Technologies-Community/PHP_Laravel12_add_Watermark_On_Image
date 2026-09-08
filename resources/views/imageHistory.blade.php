<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Watermark History</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6f9;
        }

        .main-container {
            max-width: 1200px;
            margin: 40px auto;
        }

        .history-table img {
            max-width: 80px;
            max-height: 80px;
            object-fit: contain;
            border-radius: 8px;
        }
    </style>

</head>

<body>

<div class="container main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="fw-bold">
            Watermark History
        </h1>

        <a
            href="{{ route('image.upload') }}"
            class="btn btn-primary"
        >
            Back to Tool
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <strong>Success!</strong>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    All Records
                </h4>

                <span class="badge bg-light text-dark">
                    {{ $history->total() }} Records
                </span>

            </div>

        </div>


        <div class="card-body">

            @if($history->count() > 0)

                <div class="table-responsive history-table">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Filename</th>
                                <th>Original</th>
                                <th>Type</th>
                                <th>Position</th>
                                <th>Opacity</th>
                                <th>Size</th>
                                <th>Tiled</th>
                                <th>Quality</th>
                                <th>Resize</th>
                                <th>Text</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($history as $record)

                                <tr>
                                    <td>
                                        @if(file_exists(public_path('images/' . $record->filename)))
                                            <img
                                                src="{{ asset('images/' . $record->filename) }}"
                                                alt="{{ $record->filename }}"
                                            >
                                        @else
                                            <span class="text-muted">Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $record->filename }}
                                    </td>
                                    <td>
                                        {{ $record->original_filename ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            $record->watermark_type == 'both' ? 'warning' :
                                            ($record->watermark_type == 'text' ? 'info' :
                                            ($record->watermark_type == 'logo' ? 'primary' : 'secondary'))
                                        }}">
                                            {{ ucfirst($record->watermark_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ ucfirst($record->position) }}
                                    </td>
                                    <td>
                                        {{ $record->opacity }}%
                                    </td>
                                    <td>
                                        {{ $record->watermark_size }}%
                                    </td>
                                    <td>
                                        @if($record->is_tiled)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $record->quality }}%
                                    </td>
                                    <td>
                                        @if($record->resize_width && $record->resize_height)
                                            {{ $record->resize_width }} x {{ $record->resize_height }}
                                        @elseif($record->resize_width)
                                            W: {{ $record->resize_width }}
                                        @elseif($record->resize_height)
                                            H: {{ $record->resize_height }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->text_content)
                                            {{ mb_substr($record->text_content, 0, 20) . (mb_strlen($record->text_content) > 20 ? '...' : '') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $record->email ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $record->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td>

                                        <form
                                            action="{{ route('image.history.destroy', $record->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this history record?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="mt-4">
                    {{ $history->links() }}
                </div>

            @else

                <div class="text-center py-5 text-muted">
                    <div style="font-size: 60px;"></div>
                    <h5 class="mt-3">No history records yet.</h5>
                    <p>Start watermarking images to see history here.</p>
                    <a href="{{ route('image.upload') }}" class="btn btn-primary mt-2">
                        Go to Watermark Tool
                    </a>
                </div>

            @endif

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
