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
    public function index(Request $request)
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
                'size_bytes' => $file->getSize(),
                'extension' => $extension,
                'timestamp' => $file->getMTime(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | NEW FUNCTIONALITY 4 - SEARCH
        |--------------------------------------------------------------------------
        */

        $search = trim($request->input('search', ''));

        if ($search !== '') {
            $images = array_filter($images, function ($image) use ($search) {
                return str_contains(
                    strtolower($image['name']),
                    strtolower($search)
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | NEW FUNCTIONALITY 5 - FILE TYPE FILTER
        |--------------------------------------------------------------------------
        */

        $type = strtolower($request->input('type', 'all'));

        if ($type !== 'all') {
            $images = array_filter($images, function ($image) use ($type) {
                return $image['extension'] === $type;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | NEW FUNCTIONALITY 6 - SORTING
        |--------------------------------------------------------------------------
        */

        $sort = $request->input('sort', 'newest');

        usort($images, function ($a, $b) use ($sort) {

            switch ($sort) {

                case 'oldest':
                    return $a['timestamp'] <=> $b['timestamp'];

                case 'largest':
                    return $b['size_bytes'] <=> $a['size_bytes'];

                case 'smallest':
                    return $a['size_bytes'] <=> $b['size_bytes'];

                case 'newest':
                default:
                    return $b['timestamp'] <=> $a['timestamp'];
            }
        });

        /*
        |--------------------------------------------------------------------------
        | NEW FUNCTIONALITY 7 - GALLERY STATISTICS
        |--------------------------------------------------------------------------
        */

        $allImages = [];

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            $allImages[] = [
                'extension' => $extension,
                'size' => $file->getSize(),
            ];
        }

        $statistics = [
            'total' => count($allImages),

            'jpg' => count(array_filter($allImages, function ($image) {
                return in_array($image['extension'], ['jpg', 'jpeg']);
            })),

            'png' => count(array_filter($allImages, function ($image) {
                return $image['extension'] === 'png';
            })),

            'webp' => count(array_filter($allImages, function ($image) {
                return $image['extension'] === 'webp';
            })),

            'storage' => array_sum(array_column($allImages, 'size')),
        ];

        return view('imageUpload', compact(
            'images',
            'statistics',
            'search',
            'type',
            'sort'
        ));
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

            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 1 - WATERMARK SIZE
            |--------------------------------------------------------------------------
            */

            'watermark_size' => [
                'required',
                'integer',
                'min:10',
                'max:50',
            ],

            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 2 - WATERMARK ROTATION
            |--------------------------------------------------------------------------
            */

            'rotation' => [
                'required',
                'integer',
                'min:-180',
                'max:180',
            ],

            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 3 - GRAYSCALE
            |--------------------------------------------------------------------------
            */

            'grayscale' => [
                'nullable',
                'boolean',
            ],

        ], [

            'image.required' =>
            'Please select an image.',

            'image.image' =>
            'The selected file must be a valid image.',

            'image.mimes' =>
            'Main image must be JPG, JPEG, PNG, or WEBP.',

            'image.max' =>
            'Main image must not exceed 10MB.',

            'watermark.image' =>
            'The watermark must be a valid image.',

            'watermark.mimes' =>
            'Watermark must be PNG, JPG, JPEG, or WEBP.',

            'watermark.max' =>
            'Watermark must not exceed 2MB.',

            'position.required' =>
            'Please select a watermark position.',

            'position.in' =>
            'Invalid watermark position.',

            'opacity.required' =>
            'Please select watermark opacity.',

            'opacity.integer' =>
            'Opacity must be a number.',

            'opacity.min' =>
            'Opacity must be at least 10%.',

            'opacity.max' =>
            'Opacity cannot exceed 100%.',

            'watermark_size.required' =>
            'Please select watermark size.',

            'watermark_size.integer' =>
            'Watermark size must be a number.',

            'watermark_size.min' =>
            'Watermark size must be at least 10%.',

            'watermark_size.max' =>
            'Watermark size cannot exceed 50%.',

            'rotation.required' =>
            'Please select watermark rotation.',

            'rotation.integer' =>
            'Rotation must be a number.',

            'rotation.min' =>
            'Rotation cannot be less than -180 degrees.',

            'rotation.max' =>
            'Rotation cannot exceed 180 degrees.',
        ]);


        try {

            $imageDirectory = public_path('images');

            /*
            |--------------------------------------------------------------------------
            | CREATE OUTPUT DIRECTORY
            |--------------------------------------------------------------------------
            */

            if (!File::exists($imageDirectory)) {
                File::makeDirectory(
                    $imageDirectory,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | GENERATE UNIQUE FILE NAME
            |--------------------------------------------------------------------------
            */

            $imageName =
                time() .
                '_' .
                uniqid() .
                '.' .
                strtolower($request->image->extension());


            /*
            |--------------------------------------------------------------------------
            | READ MAIN IMAGE
            |--------------------------------------------------------------------------
            */

            $img = Image::read(
                $request->image->getRealPath()
            );


            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 3
            | GRAYSCALE EFFECT
            |--------------------------------------------------------------------------
            */

            if ($request->boolean('grayscale')) {
                $img->greyscale();
            }


            /*
            |--------------------------------------------------------------------------
            | SELECT WATERMARK
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('watermark')) {

                $watermarkPath =
                    $request
                    ->file('watermark')
                    ->getRealPath();
            } else {

                $watermarkPath =
                    public_path('logo.png');

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
            |--------------------------------------------------------------------------
            | READ WATERMARK
            |--------------------------------------------------------------------------
            */

            $watermark = Image::read(
                $watermarkPath
            );


            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 1
            | WATERMARK SIZE
            |--------------------------------------------------------------------------
            */

            $watermarkSize =
                (int) $request->input(
                    'watermark_size',
                    20
                );


            $watermarkWidth = max(
                50,
                (int) round(
                    $img->width() *
                        ($watermarkSize / 100)
                )
            );


            /*
            |--------------------------------------------------------------------------
            | DON'T MAKE WATERMARK LARGER THAN IMAGE
            |--------------------------------------------------------------------------
            */

            $watermarkWidth = min(
                $watermarkWidth,
                $img->width()
            );


            /*
            |--------------------------------------------------------------------------
            | RESIZE WATERMARK
            |--------------------------------------------------------------------------
            */

            $watermark->scale(
                width: $watermarkWidth
            );


            /*
            |--------------------------------------------------------------------------
            | DARKEN WATERMARK
            |--------------------------------------------------------------------------
            */

            $watermark->brightness(-10);


            /*
            |--------------------------------------------------------------------------
            | NEW FUNCTIONALITY 2
            | WATERMARK ROTATION
            |--------------------------------------------------------------------------
            */

            $rotation =
                (int) $request->input(
                    'rotation',
                    0
                );


            if ($rotation !== 0) {

                $watermark->rotate(
                    $rotation
                );
            }


            /*
            |--------------------------------------------------------------------------
            | POSITION
            |--------------------------------------------------------------------------
            */

            $position =
                $request->input(
                    'position',
                    'bottom-right'
                );


            /*
            |--------------------------------------------------------------------------
            | OPACITY
            |--------------------------------------------------------------------------
            */

            $opacity =
                (int) $request->input(
                    'opacity',
                    70
                );


            /*
            |--------------------------------------------------------------------------
            | PADDING
            |--------------------------------------------------------------------------
            */

            $padding = 20;


            /*
            |--------------------------------------------------------------------------
            | PLACE WATERMARK
            |--------------------------------------------------------------------------
            */

            $img->place(
                $watermark,
                $position,
                $padding,
                $padding,
                $opacity
            );


            /*
            |--------------------------------------------------------------------------
            | SAVE IMAGE
            |--------------------------------------------------------------------------
            */

            $img->save(
                $imageDirectory .
                    DIRECTORY_SEPARATOR .
                    $imageName
            );


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('image.upload')
                ->with(
                    'success',
                    'Image watermarked successfully!'
                )
                ->with(
                    'image',
                    $imageName
                );
        } catch (\Throwable $e) {

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
        $filename = basename($filename);

        $path =
            public_path(
                'images' .
                    DIRECTORY_SEPARATOR .
                    $filename
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
        $filename = basename($filename);

        $path =
            public_path(
                'images' .
                    DIRECTORY_SEPARATOR .
                    $filename
            );

        if (!File::exists($path)) {

            return redirect()
                ->route('image.upload')
                ->with(
                    'error',
                    'Image not found.'
                );
        }

        File::delete($path);

        return redirect()
            ->route('image.upload')
            ->with(
                'success',
                'Image deleted successfully.'
            );
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
