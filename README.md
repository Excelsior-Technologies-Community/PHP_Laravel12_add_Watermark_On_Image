# PHP_Laravel12_Send_Notification_Using_Pusher

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=for-the-badge&logo=laravel">
  <img src="https://img.shields.io/badge/Intervention-Image%20v3-blue.svg?style=for-the-badge">
  <img src="https://img.shields.io/badge/Watermark-Enabled-success.svg?style=for-the-badge">
</p>

---

##  Overview  
This tutorial shows how to **upload an image in Laravel 12**, apply a **watermark logo**, and save the watermarked image using **Intervention Image v3**.

✔ Works with JPG, PNG, JPEG  
✔ Adds bottom-right watermark  
✔ Uses transparent PNG logo  
✔ Saves final watermarked image to `/public/images`

---

##  Features

###  Watermark Features  
- Add watermark to any uploaded image  
- Auto-resize watermark  
- Blend watermark with brightness  
- Position watermark in **bottom-right** with padding  

###  Technical Features  
- Laravel 12 compatible  
- Uses Intervention Image v3  
- Auto-registers service provider  
- No manual configuration needed  

###  Storage Features  
- Saves images to:  
  ```
  public/images/
  ```
- Requires logo watermark at:  
  ```
  public/logo.png
  ```
- Creates unique filename using timestamp  

---

##  Folder Structure  

```
app/
├── Http/
│   └── Controllers/
│       └── ImageController.php

resources/
└── views/
    └── imageUpload.blade.php

public/
├── images/
└── logo.png

routes/
└── web.php
```

---

#  Step 1 — Install Laravel 12

```bash
composer create-project laravel/laravel my-watermark-app
cd my-watermark-app
```

---

#  Step 2 — .env Setup

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

 No DB is required for watermarking —  
but `.env` must be correct to avoid Laravel errors.

---

#  Step 3 — Install Intervention Image v3

```bash
composer require intervention/image-laravel
```

✔ Laravel 12 supports v3 automatically  
✔ No provider registration needed  

---

#  Step 4 — Create Required Folders

Inside **public/** create:

```
public/images/     ← to store final watermarked images  
public/logo.png    ← your watermark logo
```

 **Logo must be transparent PNG**  
 Must be named **logo.png**

---

#  Step 5 — Add Routes  

 `routes/web.php`

```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

// Show upload page
Route::get('image-upload', [ImageController::class, 'index']);

// Process image + watermark
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');
```

---

#  Step 6 — Create Controller  

Run:

```bash
php artisan make:controller ImageController
```

 **app/Http/Controllers/ImageController.php**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    /** Show the upload form */
    public function index()
    {
        return view('imageUpload');
    }

    /** Handle upload + watermark process */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $imageName = time().'.'.$request->image->extension();

        // Load main image
        $img = Image::read($request->image->path());

        // Load watermark logo
        $watermark = Image::read(public_path('logo.png'));

        // Resize watermark (keep aspect ratio)
        $watermark->resize(80, null, function ($c) {
            $c->aspectRatio();
        });

        // Slight dark overlay for blending
        $watermark->brightness(-10);

        // Place watermark at bottom-right with padding
        $img->place($watermark, 'bottom-right', 10, 10);

        // Save final watermarked image
        $img->save(public_path('images/' . $imageName));

        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('image', $imageName);
    }
}
```

---

#  Step 7 — Create Blade View  

 **resources/views/imageUpload.blade.php**

```html
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Add Watermark Example</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">

    <div class="card mt-5">
        <h3 class="card-header p-3">Laravel 12 Add Watermark Example</h3>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

                <img 
                    src="{{ asset('images/' . session('image')) }}" 
                    style="max-width:500px; border:1px solid #ddd;"
                >
            @endif

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
```

---

#  Step 8 — Run Laravel Server  

```bash
php artisan serve
```

Visit:

```
http://localhost:8000/image-upload
```
<img width="1361" height="855" alt="logo" src="https://github.com/user-attachments/assets/3c9876f3-4445-48fa-b36d-0d81616b27c7" />

---

#  Final Output  

✔ Image uploads  
✔ Watermark applied at bottom-right  
✔ Transparent logo blends perfectly  
✔ Saved in:  
```
public/images/yourfile.png
```



