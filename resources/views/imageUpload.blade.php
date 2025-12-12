<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Add Watermark Example</title>

    <!-- Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">

    <div class="card mt-5">
        <h3 class="card-header p-3">Laravel 12 Add Watermark Example</h3>

        <div class="card-body">

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Display Success Message + Image -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

                <!-- Show final watermarked image -->
                <img 
                    src="{{ asset('images/' . session('image')) }}" 
                    style="max-width:500px; border:1px solid #ddd;"
                >
            @endif

            <!-- Upload Form -->
            <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Image:</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button class="btn btn-success">Upload</button>

            </form>

        </div>
    </div>

</div>
</body>
</html>
