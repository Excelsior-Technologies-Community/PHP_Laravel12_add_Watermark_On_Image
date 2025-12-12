<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    /**
     * Show the image upload page.
     */
    public function index()
    {
        return view('imageUpload');
    }

    /**
     * Handle image upload, process watermark, and save output.
     */
    public function store(Request $request)
    {
        // Validate image input
        $request->validate([
            'image' => 'required|image'
        ]);

        // Create unique image name
        $imageName = time().'.'.$request->image->extension();

        // Load the uploaded main image
        $img = Image::read($request->image->path());

        // Load the watermark (logo.png from public folder)
        $watermark = Image::read(public_path('logo.png'));

        // Resize watermark to small size (80px width)
        // Height becomes automatic due to aspectRatio()
        $watermark->resize(80, null, function ($c) {
            $c->aspectRatio();
        });

        // Optional: Apply slight darkening for blending effect
        $watermark->brightness(-10);

        // Place watermark at bottom-right corner with padding (10px, 10px)
        $img->place($watermark, 'bottom-right', 10, 10);

        // Save the final watermarked image to /public/images/
        $img->save(public_path('images/' . $imageName));

        // Return back to page with success message + image name
        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('image', $imageName);
    }
}
