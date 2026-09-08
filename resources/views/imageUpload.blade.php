<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Image Watermark Tool</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .main-container {
<<<<<<< HEAD
            max-width: 1150px;
=======
            max-width: 1200px;
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557
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
            text-align: center;
        }

        .upload-box:hover,
        .upload-box.dragover {
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

        .position-radio:checked+.position-card {
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
            max-height: 300px;
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
                repeating-conic-gradient(#eee 0% 25%,
                    white 0% 50%) 50% / 20px 20px;
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

<<<<<<< HEAD
        .stat-card {
            border-radius: 12px;
            padding: 18px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }

        .filter-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 18px;
        }

        .grayscale-option {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            background: white;
        }
=======
        .history-table img {
            max-width: 60px;
            max-height: 60px;
            object-fit: contain;
            border-radius: 6px;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .step-label {
            font-weight: 600;
            color: #333;
        }

        .file-count-badge {
            background: #eaf3ff;
            color: #0d6efd;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .drag-active {
            border-color: #0d6efd !important;
            background: #e7f1ff !important;
        }

        .preview-modal-img {
            max-width: 100%;
            max-height: 60vh;
            border-radius: 10px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
        }

        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            cursor: pointer;
        }

>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557
    </style>

</head>


<body>


<<<<<<< HEAD
    <div class="container main-container">


        <!-- ========================================= -->
        <!-- PAGE HEADER -->
        <!-- ========================================= -->
=======
    <!-- ========================================= -->
    <!-- PAGE HEADER -->
    <!-- ========================================= -->

    <div class="text-center mb-4">

        <h1 class="fw-bold">
            Image Watermark Tool
        </h1>

        <p class="text-muted">
            Upload image(s), add text or logo watermark, adjust size, position, opacity, and more.
        </p>

    </div>


    <!-- ========================================= -->
    <!-- SUCCESS / ERROR MESSAGES -->
    <!-- ========================================= -->
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

        <div class="text-center mb-4">

            <h1 class="fw-bold">
                🖼️ Image Watermark Tool
            </h1>

            <p class="text-muted">
                Upload an image, customize your watermark,
                and manage your processed images.
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


<<<<<<< HEAD
        <!-- ========================================= -->
        <!-- ERROR MESSAGE -->
        <!-- ========================================= -->

        @if(session('error'))
=======
    @if(session('error'))
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

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


<<<<<<< HEAD
        @if($errors->any())
=======
    @if(session('warning'))

        <div class="alert alert-warning alert-dismissible fade show">

            <strong>Warning!</strong>
            {{ session('warning') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

        <div class="alert alert-danger">

            <strong>Please fix the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


<<<<<<< HEAD
=======
    <!-- ========================================= -->
    <!-- UPLOAD FORM CARD -->
    <!-- ========================================= -->
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

        <!-- ========================================= -->
        <!-- STATISTICS -->
        <!-- ========================================= -->

<<<<<<< HEAD
        <div class="row g-3 mb-4">
=======
        <div class="card-header bg-primary text-white p-4">

            <h4 class="mb-1">
                Create Watermarked Image
            </h4>

            <small>
                Upload image(s) and customize watermark settings.
            </small>

        </div>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557


            <div class="col-6 col-md-3">

<<<<<<< HEAD
                <div class="stat-card text-center">

                    <div class="stat-number text-primary">
                        {{ $statistics['total'] }}
                    </div>
=======
            <form
                action="{{ route('image.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="watermarkForm"
            >

                @csrf


                <!-- ================================= -->
                <!-- STEP 1: MAIN IMAGE(S) -->
                <!-- ================================= -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold mb-0">
                            <span class="step-number">1</span>
                            <span class="step-label">Select Main Image(s)</span>
                        </label>
                        <span id="fileCount" class="file-count-badge d-none">
                            0 files selected
                        </span>
                    </div>

                    <div
                        class="upload-box"
                        id="dropZone"
                    >

                        <input
                            type="file"
                            name="image[]"
                            id="image"
                            class="form-control d-none"
                            accept=".jpg,.jpeg,.png,.webp"
                            multiple
                            required
                        >

                        <label for="image" style="cursor: pointer; display: block;">

                            <div style="font-size: 48px; margin-bottom: 10px;">
                                📁
                            </div>

                            <h5 class="mb-2">
                                Drag & Drop Images Here
                            </h5>

                            <p class="text-muted mb-2">
                                or click to browse
                            </p>

                            <span class="badge bg-primary">
                                JPG, JPEG, PNG, WEBP
                            </span>

                            <span class="badge bg-secondary ms-2">
                                Max 10MB each
                            </span>

                            <span class="badge bg-info text-dark ms-2">
                                Batch: up to 20
                            </span>

                        </label>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

                    <div class="stat-label">
                        Total Images
                    </div>

                </div>

<<<<<<< HEAD
            </div>
=======

                <!-- ================================= -->
                <!-- STEP 2: WATERMARK LOGO -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label
                        for="watermark"
                        class="form-label fw-bold"
                    >
                        <span class="step-number">2</span>
                        <span class="step-label">Choose Watermark Logo (Optional)</span>
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

                            Upload your own logo. Transparent PNG is recommended. Max 2MB.
                            Leave empty to use default logo.

                        </div>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557


            <div class="col-6 col-md-3">

                <div class="stat-card text-center">

                    <div class="stat-number text-danger">
                        {{ $statistics['jpg'] }}
                    </div>

                    <div class="stat-label">
                        JPG / JPEG
                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="stat-card text-center">

                    <div class="stat-number text-success">
                        {{ $statistics['png'] }}
                    </div>

                    <div class="stat-label">
                        PNG
                    </div>

                </div>

            </div>


            <div class="col-6 col-md-3">

                <div class="stat-card text-center">

                    <div class="stat-number text-warning">
                        {{ $statistics['storage'] > 0
                        ? number_format($statistics['storage'] / 1024, 2) . ' KB'
                        : '0 KB'
                    }}
                    </div>

                    <div class="stat-label">
                        Total Storage
                    </div>

                </div>

            </div>

        </div>



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
                    enctype="multipart/form-data">

                    @csrf



                    <!-- ================================= -->
                    <!-- MAIN IMAGE -->
                    <!-- ================================= -->

                    <div class="mb-4">

                        <label
                            for="image"
                            class="form-label fw-bold">
                            1. Select Main Image
                        </label>


                        <div class="upload-box">

                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                                required>


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
                            class="form-label fw-bold">
                            2. Choose Watermark Logo
                        </label>


                        <div class="upload-box">

                            <input
                                type="file"
                                name="watermark"
                                id="watermark"
                                class="form-control"
                                accept=".png,.jpg,.jpeg,.webp">


                            <div class="form-text">

                                Upload your own logo.
                                Transparent PNG is recommended.
                                Maximum size: 2MB.

                            </div>



                            <!-- Custom logo preview -->

                            <div
                                id="logoPreviewContainer"
                                class="logo-preview-container">

                                <p class="fw-semibold mb-2">
                                    Custom Logo Preview
                                </p>


                                <img
                                    id="logoPreview"
                                    class="logo-preview"
                                    src=""
                                    alt="Watermark Preview">


                                <div class="mt-2">

                                    <button
                                        type="button"
                                        id="removeLogo"
                                        class="btn btn-sm btn-outline-danger">
                                        Remove Custom Logo
                                    </button>

                                </div>

                            </div>



                            <!-- Default logo -->

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
                                        alt="Default Logo">

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>



<<<<<<< HEAD
                    <!-- ================================= -->
                    <!-- POSITION -->
                    <!-- ================================= -->
=======
                <!-- ================================= -->
                <!-- STEP 3: TEXT WATERMARK -->
                <!-- ================================= -->

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>
                            <span class="step-number">3</span>
                            Text Watermark (Optional)
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-12">

                                <label for="text_content" class="form-label">
                                    Watermark Text
                                </label>

                                <input
                                    type="text"
                                    name="text_content"
                                    id="text_content"
                                    class="form-control"
                                    placeholder="e.g. Copyright 2025, My Brand"
                                    maxlength="255"
                                    value="{{ old('text_content') }}"
                                >

                                <div class="form-text">
                                    Add text watermark. Leave empty for logo only.
                                </div>

                            </div>

                            <div class="col-md-4">

                                <label for="text_color" class="form-label">
                                    Text Color
                                </label>

                                <div class="d-flex align-items-center gap-2">

                                    <input
                                        type="color"
                                        id="textColorPicker"
                                        value="{{ old('text_color', '#000000') }}"
                                        class="color-preview"
                                    >

                                    <input
                                        type="text"
                                        name="text_color"
                                        id="text_color"
                                        class="form-control"
                                        value="{{ old('text_color', '#000000') }}"
                                        maxlength="7"
                                        style="width: 120px;"
                                    >

                                </div>

                            </div>

                            <div class="col-md-4">

                                <label for="text_size" class="form-label">
                                    Text Size (px)
                                </label>

                                <input
                                    type="number"
                                    name="text_size"
                                    id="text_size"
                                    class="form-control"
                                    value="{{ old('text_size', 24) }}"
                                    min="8"
                                    max="200"
                                >

                            </div>

                            <div class="col-md-4">

                                <label for="text_font" class="form-label">
                                    Font Family
                                </label>

                                <select
                                    name="text_font"
                                    id="text_font"
                                    class="form-select"
                                >

                                    <option value="arial" {{ old('text_font', 'arial') == 'arial' ? 'selected' : '' }}>
                                        Arial
                                    </option>

                                    <option value="verdana" {{ old('text_font', 'arial') == 'verdana' ? 'selected' : '' }}>
                                        Verdana
                                    </option>

                                    <option value="times" {{ old('text_font', 'arial') == 'times' ? 'selected' : '' }}>
                                        Times New Roman
                                    </option>

                                    <option value="courier" {{ old('text_font', 'arial') == 'courier' ? 'selected' : '' }}>
                                        Courier New
                                    </option>

                                    <option value="georgia" {{ old('text_font', 'arial') == 'georgia' ? 'selected' : '' }}>
                                        Georgia
                                    </option>

                                    <option value="impact" {{ old('text_font', 'arial') == 'impact' ? 'selected' : '' }}>
                                        Impact
                                    </option>

                                    <option value="comic" {{ old('text_font', 'arial') == 'comic' ? 'selected' : '' }}>
                                        Comic Sans MS
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- STEP 4: POSITION -->
                <!-- ================================= -->
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

                    <div class="mb-4">

<<<<<<< HEAD
                        <label class="form-label fw-bold">

                            3. Select Watermark Position

=======
                    <label class="form-label fw-bold">
                        <span class="step-number">4</span>
                        <span class="step-label">Watermark Position</span>
                    </label>

                    <div class="row g-3">

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
                <!-- STEP 5: WATERMARK SIZE -->
                <!-- ================================= -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <label class="form-label fw-bold mb-0">
                            <span class="step-number">5</span>
                            <span class="step-label">Watermark Size</span>
                        </label>

                        <span
                            id="watermarkSizeValue"
                            class="badge bg-primary"
                        >
                            {{ old('watermark_size', 20) }}%
                        </span>

                    </div>

                    <input
                        type="range"
                        class="form-range mt-2"
                        id="watermark_size"
                        name="watermark_size"
                        min="5"
                        max="100"
                        step="1"
                        value="{{ old('watermark_size', 20) }}"
                    >

                    <div class="d-flex justify-content-between text-muted small">

                        <span>
                            5% (Tiny)
                        </span>

                        <span>
                            100% (Full Width)
                        </span>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- STEP 6: TILING -->
                <!-- ================================= -->

                <div class="mb-4">

                    <div class="form-check form-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="is_tiled"
                            name="is_tiled"
                            {{ old('is_tiled') ? 'checked' : '' }}
                        >

                        <label class="form-check-label fw-bold" for="is_tiled">
                            <span class="step-number">6</span>
                            Tile / Repeat Watermark Across Image
                        </label>

                    </div>

                    <div class="form-text">
                        Enable this to repeat the watermark across the entire image (great for copyright protection).
                    </div>

                </div>


                <!-- ================================= -->
                <!-- STEP 7: OPACITY -->
                <!-- ================================= -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <label
                            for="opacity"
                            class="form-label fw-bold mb-0"
                        >
                            <span class="step-number">7</span>
                            Watermark Opacity
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557
                        </label>


                        <div class="row g-3">


                            <!-- TOP LEFT -->

                            <div class="col-6 col-md">

                                <input
                                    type="radio"
                                    name="position"
                                    id="top-left"
                                    value="top-left"
                                    class="position-radio"
                                    {{ old('position', 'bottom-right') == 'top-left' ? 'checked' : '' }}>


                                <label
                                    for="top-left"
                                    class="position-card text-center d-block">

                                    <span class="position-icon">
                                        ↖️
                                    </span>

                                    <strong>
                                        Top Left
                                    </strong>

                                </label>

                            </div>



                            <!-- TOP RIGHT -->

                            <div class="col-6 col-md">

                                <input
                                    type="radio"
                                    name="position"
                                    id="top-right"
                                    value="top-right"
                                    class="position-radio"
                                    {{ old('position', 'bottom-right') == 'top-right' ? 'checked' : '' }}>


                                <label
                                    for="top-right"
                                    class="position-card text-center d-block">

                                    <span class="position-icon">
                                        ↗️
                                    </span>

                                    <strong>
                                        Top Right
                                    </strong>

                                </label>

                            </div>



                            <!-- CENTER -->

                            <div class="col-6 col-md">

                                <input
                                    type="radio"
                                    name="position"
                                    id="center"
                                    value="center"
                                    class="position-radio"
                                    {{ old('position', 'bottom-right') == 'center' ? 'checked' : '' }}>


                                <label
                                    for="center"
                                    class="position-card text-center d-block">

                                    <span class="position-icon">
                                        ⭕
                                    </span>

                                    <strong>
                                        Center
                                    </strong>

                                </label>

                            </div>



                            <!-- BOTTOM LEFT -->

                            <div class="col-6 col-md">

                                <input
                                    type="radio"
                                    name="position"
                                    id="bottom-left"
                                    value="bottom-left"
                                    class="position-radio"
                                    {{ old('position', 'bottom-right') == 'bottom-left' ? 'checked' : '' }}>


                                <label
                                    for="bottom-left"
                                    class="position-card text-center d-block">

                                    <span class="position-icon">
                                        ↙️
                                    </span>

                                    <strong>
                                        Bottom Left
                                    </strong>

                                </label>

                            </div>



                            <!-- BOTTOM RIGHT -->

                            <div class="col-6 col-md">

                                <input
                                    type="radio"
                                    name="position"
                                    id="bottom-right"
                                    value="bottom-right"
                                    class="position-radio"
                                    {{ old('position', 'bottom-right') == 'bottom-right' ? 'checked' : '' }}>


                                <label
                                    for="bottom-right"
                                    class="position-card text-center d-block">

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


<<<<<<< HEAD

                    <!-- ================================= -->
                    <!-- OPACITY -->
                    <!-- ================================= -->

                    <div class="mb-4">


                        <div class="d-flex justify-content-between align-items-center">
=======
                    <input
                        type="range"
                        class="form-range mt-2"
                        id="opacity"
                        name="opacity"
                        min="10"
                        max="100"
                        step="5"
                        value="{{ old('opacity', 70) }}"
                    >

                    <div class="d-flex justify-content-between text-muted small">
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

                            <label
                                for="opacity"
                                class="form-label fw-bold">
                                4. Watermark Opacity
                            </label>


                            <span
                                id="opacityValue"
                                class="opacity-number">
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
                            value="{{ old('opacity', 70) }}">


                        <div class="d-flex justify-content-between text-muted small">

                            <span>
                                More Transparent
                            </span>

                            <span>
                                More Visible
                            </span>

                        </div>

                    </div>



<<<<<<< HEAD
                    <!-- ================================= -->
                    <!-- NEW 1 - WATERMARK SIZE -->
                    <!-- ================================= -->

                    <div class="mb-4">


                        <div class="d-flex justify-content-between">

                            <label
                                for="watermark_size"
                                class="form-label fw-bold">
                                5. Watermark Size
                            </label>
=======
                <!-- ================================= -->
                <!-- STEP 8: QUALITY -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label for="quality" class="form-label fw-bold">
                        <span class="step-number">8</span>
                        Output Quality
                    </label>

                    <select
                        name="quality"
                        id="quality"
                        class="form-select"
                        style="max-width: 300px;"
                    >

                        @for ($i = 100; $i >= 10; $i -= 10)
                            <option
                                value="{{ $i }}"
                                {{ old('quality', 90) == $i ? 'selected' : '' }}
                            >
                                {{ $i }}% {{ $i == 90 ? '(Recommended)' : ($i == 100 ? '(Best Quality - Large File)' : ($i == 10 ? '(Lowest Quality - Small File)' : '')) }}
                            </option>
                        @endfor

                    </select>

                    <div class="form-text">
                        Higher quality = larger file size. Applies to JPEG/WEBP output.
                    </div>

                </div>


                <!-- ================================= -->
                <!-- STEP 9: RESIZE -->
                <!-- ================================= -->

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>
                            <span class="step-number">9</span>
                            Resize Image (Optional)
                        </strong>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label for="resize_width" class="form-label">
                                    Width (px)
                                </label>

                                <input
                                    type="number"
                                    name="resize_width"
                                    id="resize_width"
                                    class="form-control"
                                    value="{{ old('resize_width') }}"
                                    placeholder="e.g. 800"
                                    min="50"
                                    max="5000"
                                >

                            </div>

                            <div class="col-md-6">

                                <label for="resize_height" class="form-label">
                                    Height (px)
                                </label>

                                <input
                                    type="number"
                                    name="resize_height"
                                    id="resize_height"
                                    class="form-control"
                                    value="{{ old('resize_height') }}"
                                    placeholder="e.g. 600"
                                    min="50"
                                    max="5000"
                                >

                            </div>

                        </div>

                        <div class="form-text mt-2">
                            Leave both empty to keep original size. Aspect ratio is maintained.
                        </div>

                    </div>

                </div>


                <!-- ================================= -->
                <!-- STEP 10: EMAIL -->
                <!-- ================================= -->

                <div class="mb-4">

                    <label for="email" class="form-label fw-bold">
                        <span class="step-number">10</span>
                        Email Watermarked Image (Optional)
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        style="max-width: 500px;"
                        placeholder="your@email.com"
                        value="{{ old('email') }}"
                    >

                    <div class="form-text">
                        Receive the watermarked image directly in your inbox.
                    </div>

                </div>


                <!-- ================================= -->
                <!-- ACTION BUTTONS -->
                <!-- ================================= -->

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                    <button
                        type="button"
                        class="btn btn-outline-primary btn-lg"
                        id="previewBtn"
                        onclick="generatePreview()"
                    >
                        Preview
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg"
                    >
                        Apply Watermark
                    </button>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557


                            <span
                                id="watermarkSizeValue"
                                class="fw-bold text-primary">
                                {{ old('watermark_size', 20) }}%
                            </span>

                        </div>


                        <input
                            type="range"
                            class="form-range"
                            id="watermark_size"
                            name="watermark_size"
                            min="10"
                            max="50"
                            step="5"
                            value="{{ old('watermark_size', 20) }}">


                        <div class="d-flex justify-content-between text-muted small">

                            <span>
                                Small
                            </span>

                            <span>
                                Large
                            </span>

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- NEW 2 - ROTATION -->
                    <!-- ================================= -->

                    <div class="mb-4">


                        <div class="d-flex justify-content-between">

                            <label
                                for="rotation"
                                class="form-label fw-bold">
                                6. Watermark Rotation
                            </label>


                            <span
                                id="rotationValue"
                                class="fw-bold text-primary">
                                {{ old('rotation', 0) }}°
                            </span>

                        </div>


                        <input
                            type="range"
                            class="form-range"
                            id="rotation"
                            name="rotation"
                            min="-180"
                            max="180"
                            step="5"
                            value="{{ old('rotation', 0) }}">


                        <div class="d-flex justify-content-between text-muted small">

                            <span>
                                -180°
                            </span>

                            <span>
                                0°
                            </span>

                            <span>
                                180°
                            </span>

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- NEW 3 - GRAYSCALE -->
                    <!-- ================================= -->

                    <div class="mb-4">

                        <div class="grayscale-option">


                            <div class="form-check form-switch">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    name="grayscale"
                                    value="1"
                                    id="grayscale"
                                    {{ old('grayscale') ? 'checked' : '' }}>


                                <label
                                    class="form-check-label fw-bold"
                                    for="grayscale">
                                    7. Apply Grayscale Effect
                                </label>

                            </div>


                            <small class="text-muted">

                                Convert the main image to black and white
                                before applying the watermark.

                            </small>

                        </div>

                    </div>



                    <!-- ================================= -->
                    <!-- SUBMIT -->
                    <!-- ================================= -->

                    <div class="d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg">

                            💧 Apply Watermark

                        </button>

                    </div>


                </form>

            </div>

        </div>



<<<<<<< HEAD
        <!-- ========================================= -->
        <!-- LATEST IMAGE -->
        <!-- ========================================= -->
=======
    <!-- ========================================= -->
    <!-- PREVIEW MODAL -->
    <!-- ========================================= -->

    <div
        class="modal fade"
        id="previewModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Preview
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body text-center">

                    <div id="previewLoading" class="d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Generating preview...</p>
                    </div>

                    <div id="previewError" class="alert alert-danger d-none">
                    </div>

                    <img
                        id="previewImage"
                        class="preview-modal-img d-none"
                        src=""
                        alt="Preview"
                    >

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                </div>

            </div>
        </div>

    </div>


    <!-- ========================================= -->
    <!-- LATEST PROCESSED IMAGE -->
    <!-- ========================================= -->
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

        @if(session('image'))

        <div class="card shadow-sm mb-5">


            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    Latest Watermarked Image
                </h4>

            </div>


            <div class="card-body">


                <div class="preview-box text-center">

                    <img
                        src="{{ asset('images/' . session('image')) }}"
                        alt="Watermarked Image">

                </div>


                <div class="text-center mt-3 d-flex justify-content-center gap-2 flex-wrap">

                    <a
                        href="{{ route('image.download', session('image')) }}"
<<<<<<< HEAD
                        class="btn btn-success">
                        ⬇️ Download Image
=======
                        class="btn btn-success"
                    >
                        Download
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557
                    </a>

                    <form
                        action="{{ route('image.email', session('image')) }}"
                        method="POST"
                        class="d-inline"
                    >

                        @csrf

                        <div class="input-group" style="max-width: 400px;">

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter email to send"
                                required
                            >

                            <button
                                type="submit"
                                class="btn btn-outline-primary"
                            >
                                Send via Email
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        @endif



<<<<<<< HEAD
        <!-- ========================================= -->
        <!-- GALLERY -->
        <!-- ========================================= -->
=======
    <div class="card shadow-sm mb-5">
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

        <div class="card shadow-sm">


<<<<<<< HEAD
            <div class="card-header bg-dark text-white">

                <div class="d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        🖼️ Watermarked Image Gallery
                    </h4>


                    <span class="badge bg-light text-dark">

                        {{ count($images) }}

                        Results

                    </span>

                </div>

            </div>


            <div class="card-body">



                <!-- ===================================== -->
                <!-- NEW 4, 5, 6 - SEARCH FILTER SORT -->
                <!-- ===================================== -->

                <div class="filter-box mb-4">


                    <form
                        method="GET"
                        action="{{ route('image.upload') }}">

                        <div class="row g-3">


                            <!-- SEARCH -->

                            <div class="col-md-5">

                                <label class="form-label fw-bold">
                                    🔎 Search
                                </label>


                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search image name..."
                                    value="{{ $search }}">

                            </div>



                            <!-- FILE TYPE -->

                            <div class="col-md-3">

                                <label class="form-label fw-bold">
                                    📁 File Type
                                </label>


                                <select
                                    name="type"
                                    class="form-select">

                                    <option
                                        value="all"
                                        {{ $type == 'all' ? 'selected' : '' }}>
                                        All Types
                                    </option>


                                    <option
                                        value="jpg"
                                        {{ $type == 'jpg' ? 'selected' : '' }}>
                                        JPG / JPEG
                                    </option>


                                    <option
                                        value="png"
                                        {{ $type == 'png' ? 'selected' : '' }}>
                                        PNG
                                    </option>


                                    <option
                                        value="webp"
                                        {{ $type == 'webp' ? 'selected' : '' }}>
                                        WEBP
                                    </option>

                                </select>

                            </div>



                            <!-- SORT -->

                            <div class="col-md-3">

                                <label class="form-label fw-bold">
                                    ↕️ Sort
                                </label>


                                <select
                                    name="sort"
                                    class="form-select">

                                    <option
                                        value="newest"
                                        {{ $sort == 'newest' ? 'selected' : '' }}>
                                        Newest First
                                    </option>


                                    <option
                                        value="oldest"
                                        {{ $sort == 'oldest' ? 'selected' : '' }}>
                                        Oldest First
                                    </option>


                                    <option
                                        value="largest"
                                        {{ $sort == 'largest' ? 'selected' : '' }}>
                                        Largest First
                                    </option>


                                    <option
                                        value="smallest"
                                        {{ $sort == 'smallest' ? 'selected' : '' }}>
                                        Smallest First
                                    </option>

                                </select>

                            </div>



                            <!-- BUTTONS -->

                            <div class="col-md-1 d-flex align-items-end">

                                <div class="d-grid w-100">

                                    <button
                                        type="submit"
                                        class="btn btn-primary">
                                        Go
                                    </button>

                                </div>

                            </div>


                        </div>

                        <!-- CLEAR FILTER -->

                        @if($search || $type != 'all' || $sort != 'newest')

                        <div class="mt-3">

                            <a
                                href="{{ route('image.upload') }}"
                                class="btn btn-sm btn-outline-secondary">
                                ✖ Clear Filters
                            </a>

                        </div>

                        @endif

                    </form>

                </div>



                <!-- ===================================== -->
                <!-- GALLERY -->
                <!-- ===================================== -->

                @if(count($images) > 0)


                <div class="row g-4">


                    @foreach($images as $image)


                    <div class="col-md-6 col-lg-4">


                        <div
                            class="card gallery-card shadow-sm h-100">


                            <div class="card-body">


                                <!-- IMAGE -->

                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['name'] }}"
                                    class="gallery-image mb-3">


                                <!-- FILE NAME -->

                                <h6
                                    class="text-truncate"
                                    title="{{ $image['name'] }}">

                                    {{ $image['name'] }}

                                </h6>



                                <!-- FILE INFO -->

                                <div class="small text-muted mb-3">


                                    <div>
                                        📅 {{ $image['date'] }}
                                    </div>


                                    <div>
                                        💾 {{ $image['size'] }}
                                    </div>


                                    <div>
                                        📁 {{ strtoupper($image['extension']) }}
                                    </div>


                                </div>



                                <!-- BUTTONS -->

                                <div class="d-flex gap-2">


                                    <a
                                        href="{{ route('image.download', $image['name']) }}"
                                        class="btn btn-success btn-sm flex-fill">
                                        ⬇️ Download
                                    </a>



                                    <form
                                        action="{{ route('image.destroy', $image['name']) }}"
                                        method="POST"
                                        class="flex-fill"
                                        onsubmit="return confirm('Are you sure you want to delete this image?');">

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm w-100">
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
                        No images found
                    </h5>


                    <p class="text-muted">

                        Try changing your search or filter.

                    </p>


                    <a
                        href="{{ route('image.upload') }}"
                        class="btn btn-primary">
                        Show All Images
                    </a>


                </div>


                @endif
=======
                <h4 class="mb-0">
                    Watermarked Image Gallery
                </h4>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557


            </div>

        </div>


<<<<<<< HEAD
    </div>

=======
        <div class="card-body">

            @if(count($images) > 0)

                <div class="row g-4">

                    @foreach($images as $image)

                        <div class="col-md-6 col-lg-4">

                            <div class="card gallery-card shadow-sm h-100">

                                <div class="card-body">

                                    <img
                                        src="{{ $image['url'] }}"
                                        alt="{{ $image['name'] }}"
                                        class="gallery-image mb-3"
                                    >

                                    <h6
                                        class="text-truncate"
                                        title="{{ $image['name'] }}"
                                    >
                                        {{ $image['name'] }}
                                    </h6>

                                    <div class="small text-muted mb-3">

                                        <div>
                                             {{ $image['date'] }}
                                        </div>

                                        <div>
                                             {{ $image['size'] }}
                                        </div>

                                    </div>

                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('image.download', $image['name']) }}"
                                            class="btn btn-success btn-sm flex-fill"
                                        >
                                            Download
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
                                                Delete
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
                        
                    </div>

                    <h5 class="mt-3">
                        No watermarked images yet
                    </h5>

                    <p class="text-muted">
                        Upload an image above to create your first watermarked image.
                    </p>

                </div>

            @endif

        </div>

    </div>


    <!-- ========================================= -->
    <!-- WATERMARK HISTORY -->
    <!-- ========================================= -->

    <div class="card shadow-sm">

        <div class="card-header bg-info text-dark">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Recent History
                </h4>

                <a
                    href="{{ route('image.history') }}"
                    class="btn btn-sm btn-outline-dark"
                >
                    View All
                </a>

            </div>

        </div>


        <div class="card-body">

            @if($history->count() > 0)

                <div class="table-responsive history-table">

                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>Filename</th>
                                <th>Type</th>
                                <th>Position</th>
                                <th>Opacity</th>
                                <th>Size</th>
                                <th>Date</th>
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
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $record->filename }}
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
                                        {{ $record->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-4 text-muted">
                    No history records yet.
                </div>

            @endif

        </div>

    </div>

</div>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557


    <!-- ========================================= -->
    <!-- JAVASCRIPT -->
    <!-- ========================================= -->

    <script>
        /*
    |--------------------------------------------------------------------------
    | DRAG & DROP UPLOAD
    |--------------------------------------------------------------------------
    */

<<<<<<< HEAD
        const opacitySlider =
            document.getElementById('opacity');

        const opacityValue =
            document.getElementById('opacityValue');


        opacitySlider.addEventListener(
            'input',
            function() {

                opacityValue.textContent =
                    this.value + '%';

            }
        );



        /*
        |--------------------------------------------------------------------------
        | WATERMARK SIZE SLIDER
        |--------------------------------------------------------------------------
        */

        const watermarkSize =
            document.getElementById('watermark_size');

        const watermarkSizeValue =
            document.getElementById('watermarkSizeValue');


        watermarkSize.addEventListener(
            'input',
            function() {

                watermarkSizeValue.textContent =
                    this.value + '%';

            }
        );



        /*
        |--------------------------------------------------------------------------
        | ROTATION SLIDER
        |--------------------------------------------------------------------------
        */

        const rotation =
            document.getElementById('rotation');

        const rotationValue =
            document.getElementById('rotationValue');


        rotation.addEventListener(
            'input',
            function() {

                rotationValue.textContent =
                    this.value + '°';

            }
        );



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
            document.getElementById(
                'logoPreviewContainer'
            );

        const removeLogo =
            document.getElementById('removeLogo');


        watermarkInput.addEventListener(
            'change',
            function(event) {


                const file =
                    event.target.files[0];


                if (!file) {

                    logoPreviewContainer.style.display =
                        'none';

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | CHECK IMAGE
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | CREATE PREVIEW
                |--------------------------------------------------------------------------
                */

                const reader =
                    new FileReader();


                reader.onload =
                    function(e) {

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
            function() {

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

=======
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('image');
    const fileCount = document.getElementById('fileCount');

    dropZone.addEventListener('click', function (e) {
        if (e.target.tagName !== 'INPUT') {
            imageInput.click();
        }
    });

    imageInput.addEventListener('change', function () {
        updateFileCount(this.files);
    });

    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropZone.classList.add('drag-active');
    });

    dropZone.addEventListener('dragleave', function (e) {
        e.preventDefault();
        dropZone.classList.remove('drag-active');
    });

    dropZone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropZone.classList.remove('drag-active');

        const files = e.dataTransfer.files;

        if (files.length > 0) {
            imageInput.files = files;
            updateFileCount(files);
        }
    });

    function updateFileCount(files) {
        if (files.length > 0) {
            fileCount.textContent = files.length + ' file' + (files.length > 1 ? 's' : '') + ' selected';
            fileCount.classList.remove('d-none');
        } else {
            fileCount.classList.add('d-none');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOM WATERMARK PREVIEW
    |--------------------------------------------------------------------------
    */

    const watermarkInput = document.getElementById('watermark');
    const logoPreview = document.getElementById('logoPreview');
    const logoPreviewContainer = document.getElementById('logoPreviewContainer');
    const removeLogo = document.getElementById('removeLogo');

    watermarkInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (!file) {
            logoPreviewContainer.style.display = 'none';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            watermarkInput.value = '';
            logoPreviewContainer.style.display = 'none';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            logoPreview.src = e.target.result;
            logoPreviewContainer.style.display = 'block';
        };

        reader.readAsDataURL(file);
    });

    removeLogo.addEventListener('click', function () {
        watermarkInput.value = '';
        logoPreview.src = '';
        logoPreviewContainer.style.display = 'none';
    });


    /*
    |--------------------------------------------------------------------------
    | OPACITY SLIDER
    |--------------------------------------------------------------------------
    */

    const opacitySlider = document.getElementById('opacity');
    const opacityValue = document.getElementById('opacityValue');

    if (opacitySlider) {
        opacitySlider.addEventListener('input', function () {
            opacityValue.textContent = this.value + '%';
        });
    }


    /*
    |--------------------------------------------------------------------------
    | WATERMARK SIZE SLIDER
    |--------------------------------------------------------------------------
    */

    const watermarkSizeSlider = document.getElementById('watermark_size');
    const watermarkSizeValue = document.getElementById('watermarkSizeValue');

    if (watermarkSizeSlider) {
        watermarkSizeSlider.addEventListener('input', function () {
            watermarkSizeValue.textContent = this.value + '%';
        });
    }


    /*
    |--------------------------------------------------------------------------
    | TEXT COLOR PICKER SYNC
    |--------------------------------------------------------------------------
    */

    const textColorPicker = document.getElementById('textColorPicker');
    const textColorInput = document.getElementById('text_color');

    if (textColorPicker && textColorInput) {
        textColorPicker.addEventListener('input', function () {
            textColorInput.value = this.value;
        });

        textColorInput.addEventListener('input', function () {
            textColorPicker.value = this.value;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW GENERATION
    |--------------------------------------------------------------------------
    */

    async function generatePreview() {
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const previewImage = document.getElementById('previewImage');
        const previewLoading = document.getElementById('previewLoading');
        const previewError = document.getElementById('previewError');

        previewImage.classList.add('d-none');
        previewError.classList.add('d-none');
        previewLoading.classList.remove('d-none');

        previewModal.show();

        const formData = new FormData();

        const imageFiles = document.getElementById('image').files;

        if (imageFiles.length === 0) {
            previewLoading.classList.add('d-none');
            previewError.textContent = 'Please select an image first.';
            previewError.classList.remove('d-none');
            return;
        }

        formData.append('image', imageFiles[0]);

        const watermarkFile = document.getElementById('watermark').files[0];

        if (watermarkFile) {
            formData.append('watermark', watermarkFile);
        }

        formData.append('text_content', document.getElementById('text_content').value || '');
        formData.append('text_color', document.getElementById('text_color').value || '#000000');
        formData.append('text_size', document.getElementById('text_size').value || 24);
        formData.append('text_font', document.getElementById('text_font').value || 'arial');
        formData.append('position', document.querySelector('input[name="position"]:checked')?.value || 'bottom-right');
        formData.append('opacity', document.getElementById('opacity').value || 70);
        formData.append('watermark_size', document.getElementById('watermark_size').value || 20);
        formData.append('quality', document.getElementById('quality').value || 90);
        formData.append('is_tiled', document.getElementById('is_tiled').checked ? '1' : '0');

        const resizeWidth = document.getElementById('resize_width').value;
        const resizeHeight = document.getElementById('resize_height').value;

        if (resizeWidth) formData.append('resize_width', resizeWidth);
        if (resizeHeight) formData.append('resize_height', resizeHeight);

        try {
            const response = await fetch('{{ route('image.preview') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                },
                body: formData,
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = URL.createObjectURL(blob);

                previewImage.src = url;
                previewImage.classList.remove('d-none');
            } else {
                const errorData = await response.json();
                previewError.textContent = errorData.error || 'Preview generation failed.';
                previewError.classList.remove('d-none');
            }

        } catch (error) {
            previewError.textContent = 'Preview generation failed: ' + error.message;
            previewError.classList.remove('d-none');
        } finally {
            previewLoading.classList.add('d-none');
        }
    }

</script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557

</body>

</html>
