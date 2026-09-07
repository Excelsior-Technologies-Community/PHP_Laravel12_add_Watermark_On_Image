<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Image Watermark Tool</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f4f6f9;
        }

        .main-container {
            max-width: 1100px;
            margin: 40px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 12px;
            padding: 25px;
            background: #fafafa;
            transition: 0.3s;
        }

        .upload-box:hover {
            border-color: #0d6efd;
            background: #f0f7ff;
        }

        .position-card {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: 0.2s;
            height: 100%;
        }

        .position-card:hover {
            border-color: #0d6efd;
            background: #f8fbff;
        }

        .position-radio:checked + .position-card {
            border-color: #0d6efd;
            background: #eaf3ff;
        }

        .position-radio {
            display: none;
        }

        .position-icon {
            font-size: 25px;
            display: block;
            margin-bottom: 5px;
        }

        .opacity-number {
            font-size: 22px;
            font-weight: bold;
            color: #0d6efd;
        }

        .preview-box {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;
        }

        .gallery-image {
            width: 100%;
            height: 220px;
            object-fit: contain;
            border-radius: 10px;
        }

        .gallery-card {
            transition: 0.2s;
        }

        .gallery-card:hover {
            transform: translateY(-3px);
        }

        .logo-preview-container {
            display: none;
            margin-top: 15px;
        }

        .logo-preview {
            max-width: 180px;
            max-height: 120px;
            object-fit: contain;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px;
            background:
                repeating-conic-gradient(
                    #eee 0% 25%,
                    white 0% 50%
                ) 50% / 20px 20px;
        }

        .default-logo-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
        }

        .default-logo-box img {
            max-width: 120px;
            max-height: 80px;
            object-fit: contain;
        }

    </style>

</head>

<body>

<div class="container main-container">

    <!-- ========================================= -->
    <!-- PAGE HEADER -->
    <!-- ========================================= -->

    <div class="text-center mb-4">

        <h1 class="fw-bold">
            🖼️ Image Watermark Tool
        </h1>

        <p class="text-muted">
            Upload an image, choose your own watermark logo,
            adjust its position and opacity.
        </p>

    </div>


    <!-- ========================================= -->
    <!-- SUCCESS MESSAGE -->
    <!-- ========================================= -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <strong>Success!</strong>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <!-- ========================================= -->
    <!-- ERROR MESSAGE -->
    <!-- ========================================= -->

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>Error!</strong>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- ========================================= -->
    <!-- UPLOAD CARD -->
    <!-- ========================================= -->

    <div class="card shadow-sm mb-5">

        <div class="card-header bg-primary text-white p-4">

            <h4 class="mb-1">
                ✨ Create Watermarked Image
            </h4>

            <small>
                Customize your watermark before processing.
            </small>

        </div>


        <div class="card-body p-4">

            <form
                action="{{ route('image.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <!-- ================================= -->
                <!-- MAIN IMAGE -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label
                        for="image"
                        class="form-label fw-bold"
                    >
                        1. Select Main Image
                    </label>

                    <div class="upload-box">

                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >

                        <div class="form-text">

                            JPG, JPEG, PNG or WEBP.
                            Maximum size: 10MB.

                        </div>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- CUSTOM WATERMARK -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label
                        for="watermark"
                        class="form-label fw-bold"
                    >
                        2. Choose Watermark Logo
                    </label>

                    <div class="upload-box">

                        <input
                            type="file"
                            name="watermark"
                            id="watermark"
                            class="form-control"
                            accept=".png,.jpg,.jpeg,.webp"
                        >

                        <div class="form-text">

                            Upload your own logo.
                            Transparent PNG is recommended.
                            Maximum size: 2MB.

                        </div>


                        <!-- Custom logo preview -->

                        <div
                            id="logoPreviewContainer"
                            class="logo-preview-container"
                        >

                            <p class="fw-semibold mb-2">
                                Custom Logo Preview
                            </p>

                            <img
                                id="logoPreview"
                                class="logo-preview"
                                src=""
                                alt="Watermark Preview"
                            >

                            <div class="mt-2">

                                <button
                                    type="button"
                                    id="removeLogo"
                                    class="btn btn-sm btn-outline-danger"
                                >
                                    Remove Custom Logo
                                </button>

                            </div>

                        </div>


                        <!-- Default logo information -->

                        <div class="default-logo-box mt-3">

                            <div class="d-flex align-items-center gap-3">

                                <div>

                                    <strong>
                                        Default Logo
                                    </strong>

                                    <p class="small text-muted mb-0">
                                        If you don't upload a logo,
                                        <code>public/logo.png</code>
                                        will be used automatically.
                                    </p>

                                </div>

                                @if(file_exists(public_path('logo.png')))

                                    <img
                                        src="{{ asset('logo.png') }}"
                                        alt="Default Logo"
                                    >

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- POSITION -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label class="form-label fw-bold">

                        3. Select Watermark Position

                    </label>


                    <div class="row g-3">


                        <!-- Top Left -->

                        <div class="col-6 col-md">

                            <input
                                type="radio"
                                name="position"
                                id="top-left"
                                value="top-left"
                                class="position-radio"
                                {{ old('position', 'bottom-right') == 'top-left' ? 'checked' : '' }}
                            >

                            <label
                                for="top-left"
                                class="position-card text-center d-block"
                            >

                                <span class="position-icon">
                                    ↖️
                                </span>

                                <strong>
                                    Top Left
                                </strong>

                            </label>

                        </div>


                        <!-- Top Right -->

                        <div class="col-6 col-md">

                            <input
                                type="radio"
                                name="position"
                                id="top-right"
                                value="top-right"
                                class="position-radio"
                                {{ old('position', 'bottom-right') == 'top-right' ? 'checked' : '' }}
                            >

                            <label
                                for="top-right"
                                class="position-card text-center d-block"
                            >

                                <span class="position-icon">
                                    ↗️
                                </span>

                                <strong>
                                    Top Right
                                </strong>

                            </label>

                        </div>


                        <!-- Center -->

                        <div class="col-6 col-md">

                            <input
                                type="radio"
                                name="position"
                                id="center"
                                value="center"
                                class="position-radio"
                                {{ old('position', 'bottom-right') == 'center' ? 'checked' : '' }}
                            >

                            <label
                                for="center"
                                class="position-card text-center d-block"
                            >

                                <span class="position-icon">
                                    ⭕
                                </span>

                                <strong>
                                    Center
                                </strong>

                            </label>

                        </div>


                        <!-- Bottom Left -->

                        <div class="col-6 col-md">

                            <input
                                type="radio"
                                name="position"
                                id="bottom-left"
                                value="bottom-left"
                                class="position-radio"
                                {{ old('position', 'bottom-right') == 'bottom-left' ? 'checked' : '' }}
                            >

                            <label
                                for="bottom-left"
                                class="position-card text-center d-block"
                            >

                                <span class="position-icon">
                                    ↙️
                                </span>

                                <strong>
                                    Bottom Left
                                </strong>

                            </label>

                        </div>


                        <!-- Bottom Right -->

                        <div class="col-6 col-md">

                            <input
                                type="radio"
                                name="position"
                                id="bottom-right"
                                value="bottom-right"
                                class="position-radio"
                                {{ old('position', 'bottom-right') == 'bottom-right' ? 'checked' : '' }}
                            >

                            <label
                                for="bottom-right"
                                class="position-card text-center d-block"
                            >

                                <span class="position-icon">
                                    ↘️
                                </span>

                                <strong>
                                    Bottom Right
                                </strong>

                            </label>

                        </div>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- OPACITY -->
                <!-- ================================= -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <label
                            for="opacity"
                            class="form-label fw-bold"
                        >
                            4. Watermark Opacity
                        </label>

                        <span
                            id="opacityValue"
                            class="opacity-number"
                        >
                            {{ old('opacity', 70) }}%
                        </span>

                    </div>


                    <input
                        type="range"
                        class="form-range"
                        id="opacity"
                        name="opacity"
                        min="10"
                        max="100"
                        step="5"
                        value="{{ old('opacity', 70) }}"
                    >


                    <div class="d-flex justify-content-between text-muted small">

                        <span>
                            More Transparent
                        </span>

                        <span>
                            More Visible
                        </span>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- SUBMIT -->
                <!-- ================================= -->

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg"
                    >

                        💧 Apply Watermark

                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- ========================================= -->
    <!-- LATEST PROCESSED IMAGE -->
    <!-- ========================================= -->

    @if(session('image'))

        <div class="card shadow-sm mb-5">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    ✅ Latest Watermarked Image
                </h4>

            </div>


            <div class="card-body">

                <div class="preview-box text-center">

                    <img
                        src="{{ asset('images/' . session('image')) }}"
                        alt="Watermarked Image"
                    >

                </div>


                <div class="text-center mt-3">

                    <a
                        href="{{ route('image.download', session('image')) }}"
                        class="btn btn-success"
                    >
                        ⬇️ Download Image
                    </a>

                </div>

            </div>

        </div>

    @endif


    <!-- ========================================= -->
    <!-- IMAGE GALLERY -->
    <!-- ========================================= -->

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    🖼️ Watermarked Image Gallery
                </h4>

                <span class="badge bg-light text-dark">
                    {{ count($images) }} Images
                </span>

            </div>

        </div>


        <div class="card-body">


            @if(count($images) > 0)

                <div class="row g-4">

                    @foreach($images as $image)

                        <div class="col-md-6 col-lg-4">

                            <div class="card gallery-card shadow-sm h-100">

                                <div class="card-body">

                                    <!-- Image -->

                                    <img
                                        src="{{ $image['url'] }}"
                                        alt="{{ $image['name'] }}"
                                        class="gallery-image mb-3"
                                    >


                                    <!-- File information -->

                                    <h6
                                        class="text-truncate"
                                        title="{{ $image['name'] }}"
                                    >
                                        {{ $image['name'] }}
                                    </h6>


                                    <div class="small text-muted mb-3">

                                        <div>
                                            📅 {{ $image['date'] }}
                                        </div>

                                        <div>
                                            💾 {{ $image['size'] }}
                                        </div>

                                    </div>


                                    <!-- Buttons -->

                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('image.download', $image['name']) }}"
                                            class="btn btn-success btn-sm flex-fill"
                                        >
                                            ⬇️ Download
                                        </a>


                                        <form
                                            action="{{ route('image.destroy', $image['name']) }}"
                                            method="POST"
                                            class="flex-fill"
                                            onsubmit="return confirm('Are you sure you want to delete this image?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm w-100"
                                            >
                                                🗑️ Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-center py-5">

                    <div style="font-size: 60px;">
                        🖼️
                    </div>

                    <h5 class="mt-3">
                        No watermarked images yet
                    </h5>

                    <p class="text-muted">
                        Upload an image above to create your first
                        watermarked image.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


<!-- ========================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================= -->

<script>

    /*
    |--------------------------------------------------------------------------
    | OPACITY SLIDER
    |--------------------------------------------------------------------------
    */

    const opacitySlider =
        document.getElementById('opacity');

    const opacityValue =
        document.getElementById('opacityValue');


    opacitySlider.addEventListener('input', function () {

        opacityValue.textContent =
            this.value + '%';

    });


    /*
    |--------------------------------------------------------------------------
    | CUSTOM WATERMARK PREVIEW
    |--------------------------------------------------------------------------
    */

    const watermarkInput =
        document.getElementById('watermark');

    const logoPreview =
        document.getElementById('logoPreview');

    const logoPreviewContainer =
        document.getElementById('logoPreviewContainer');

    const removeLogo =
        document.getElementById('removeLogo');


    watermarkInput.addEventListener(
        'change',
        function (event) {

            const file =
                event.target.files[0];


            if (!file) {

                logoPreviewContainer.style.display =
                    'none';

                return;

            }


            /*
             * Make sure browser-selected file is an image.
             */

            if (!file.type.startsWith('image/')) {

                alert(
                    'Please select a valid image file.'
                );

                watermarkInput.value = '';

                logoPreviewContainer.style.display =
                    'none';

                return;

            }


            /*
             * Create temporary browser preview.
             */

            const reader =
                new FileReader();


            reader.onload = function (e) {

                logoPreview.src =
                    e.target.result;

                logoPreviewContainer.style.display =
                    'block';

            };


            reader.readAsDataURL(file);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REMOVE CUSTOM LOGO
    |--------------------------------------------------------------------------
    */

    removeLogo.addEventListener(
        'click',
        function () {

            watermarkInput.value = '';

            logoPreview.src = '';

            logoPreviewContainer.style.display =
                'none';

        }
    );

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>