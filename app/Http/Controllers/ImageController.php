<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    /**
     * Display upload page and image gallery.
     */
    public function index()
    {
        $imageDirectory = public_path('images');

        // Create images directory if it does not exist
        if (!File::exists($imageDirectory)) {
            File::makeDirectory($imageDirectory, 0755, true);
        }

        $images = [];

        $files = File::files($imageDirectory);

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            $images[] = [
                'name' => $file->getFilename(),
                'url' => asset('images/' . $file->getFilename()),
                'date' => date('d M Y, h:i A', $file->getMTime()),
                'size' => $this->formatFileSize($file->getSize()),
                'timestamp' => $file->getMTime(),
            ];
        }

        // Newest images first
        usort($images, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return view('imageUpload', compact('images'));
    }

    /**
     * Process uploaded image and watermark.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'watermark' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:2048',
            ],

            'position' => [
                'required',
                'in:top-left,top-right,center,bottom-left,bottom-right',
            ],

            'opacity' => [
                'required',
                'integer',
                'min:10',
                'max:100',
            ],
        ], [
            'image.required' => 'Please select an image.',
            'image.image' => 'The selected file must be a valid image.',
            'image.mimes' => 'Main image must be JPG, JPEG, PNG, or WEBP.',
            'image.max' => 'Main image must not exceed 10MB.',

            'watermark.image' => 'The watermark must be a valid image.',
            'watermark.mimes' => 'Watermark must be PNG, JPG, JPEG, or WEBP.',
            'watermark.max' => 'Watermark must not exceed 2MB.',

            'position.required' => 'Please select a watermark position.',
            'position.in' => 'Invalid watermark position.',

            'opacity.required' => 'Please select watermark opacity.',
            'opacity.integer' => 'Opacity must be a number.',
            'opacity.min' => 'Opacity must be at least 10%.',
            'opacity.max' => 'Opacity cannot exceed 100%.',
        ]);

        try {
            $imageDirectory = public_path('images');

            // Make sure output directory exists
            if (!File::exists($imageDirectory)) {
                File::makeDirectory($imageDirectory, 0755, true);
            }

            /*
             * Generate a unique filename.
             */
            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                strtolower($request->image->extension());

            /*
             * Read the uploaded main image.
             */
            $img = Image::read($request->image->getRealPath());

            /*
             * -------------------------------------------------------
             * CUSTOM WATERMARK
             * -------------------------------------------------------
             *
             * If user uploads a watermark, use it.
             *
             * Otherwise use:
             *
             * public/logo.png
             */
            if ($request->hasFile('watermark')) {

                $watermarkPath = $request
                    ->file('watermark')
                    ->getRealPath();

            } else {

                $watermarkPath = public_path('logo.png');

                // Make sure default watermark exists
                if (!File::exists($watermarkPath)) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'watermark' =>
                                'Default watermark logo.png was not found in the public folder.'
                        ]);
                }
            }

            /*
             * Read watermark image.
             */
            $watermark = Image::read($watermarkPath);

            /*
             * -------------------------------------------------------
             * WATERMARK SIZE
             * -------------------------------------------------------
             *
             * Watermark width = 20% of original image width.
             *
             * Minimum width = 50px.
             */
            $watermarkWidth = max(
                50,
                (int) round($img->width() * 0.20)
            );

            /*
             * Don't make watermark larger than original image.
             */
            $watermarkWidth = min(
                $watermarkWidth,
                $img->width()
            );

            /*
             * Resize watermark while maintaining aspect ratio.
             */
            $watermark->scale(
                width: $watermarkWidth
            );

            /*
             * Slightly darken watermark.
             *
             * This keeps the original behavior of the project.
             */
            $watermark->brightness(-10);

            /*
             * -------------------------------------------------------
             * WATERMARK POSITION
             * -------------------------------------------------------
             */
            $position = $request->input(
                'position',
                'bottom-right'
            );

            /*
             * -------------------------------------------------------
             * WATERMARK OPACITY
             * -------------------------------------------------------
             *
             * Intervention Image v3 supports opacity directly
             * through the place() method.
             */
            $opacity = (int) $request->input(
                'opacity',
                70
            );

            /*
             * Padding from image edges.
             */
            $padding = 20;

            /*
             * -------------------------------------------------------
             * PLACE WATERMARK
             * -------------------------------------------------------
             */
            $img->place(
                $watermark,
                $position,
                $padding,
                $padding,
                $opacity
            );

            /*
             * Save processed image.
             */
            $img->save(
                $imageDirectory . DIRECTORY_SEPARATOR . $imageName
            );

            /*
             * Redirect back with success message.
             */
            return redirect()
                ->route('image.upload')
                ->with('success', 'Image watermarked successfully!')
                ->with('image', $imageName);

        } catch (\Throwable $e) {

            /*
             * Return friendly error instead of showing
             * a Laravel exception page to the user.
             */
            return back()
                ->withInput()
                ->withErrors([
                    'image' =>
                        'Unable to process the image. Please make sure the uploaded files are valid images.'
                ]);
        }
    }

    /**
     * Download processed image.
     */
    public function download($filename)
    {
        /*
         * basename() prevents path traversal.
         */
        $filename = basename($filename);

        $path = public_path(
            'images' . DIRECTORY_SEPARATOR . $filename
        );

        if (!File::exists($path)) {
            abort(404, 'Image not found.');
        }

        return response()->download($path);
    }

    /**
     * Delete processed image.
     */
    public function destroy($filename)
    {
        /*
         * basename() prevents path traversal.
         */
        $filename = basename($filename);

        $path = public_path(
            'images' . DIRECTORY_SEPARATOR . $filename
        );

        if (!File::exists($path)) {
            return redirect()
                ->route('image.upload')
                ->with('error', 'Image not found.');
        }

        File::delete($path);

        return redirect()
            ->route('image.upload')
            ->with('success', 'Image deleted successfully.');
    }

    /**
     * Format file size.
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1024 * 1024) {
            return round(
                $bytes / (1024 * 1024),
                2
            ) . ' MB';
        }

        if ($bytes >= 1024) {
            return round(
                $bytes / 1024,
                2
            ) . ' KB';
        }

        return $bytes . ' bytes';
    }
}