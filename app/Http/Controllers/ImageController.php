<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\WatermarkHistory;
use App\Mail\WatermarkedImageMail;

class ImageController extends Controller
{
    /**
     * Display upload page, gallery, and history.
     */
    public function index()
    {
        $imageDirectory = public_path('images');

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

        usort($images, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        $history = WatermarkHistory::orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('imageUpload', compact('images', 'history'));
    }

    /**
     * Process uploaded image(s) and watermark.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => [
                'required',
                'array',
                'min:1',
                'max:20',
            ],
            'image.*' => [
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

            'text_content' => [
                'nullable',
                'string',
                'max:255',
            ],

            'text_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'text_size' => [
                'nullable',
                'integer',
                'min:8',
                'max:200',
            ],

            'text_font' => [
                'nullable',
                'string',
                'max:50',
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

            'watermark_size' => [
                'required',
                'integer',
                'min:5',
                'max:100',
            ],

            'is_tiled' => [
                'sometimes',
                'accepted',
            ],

            'quality' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'resize_width' => [
                'nullable',
                'integer',
                'min:50',
                'max:5000',
            ],

            'resize_height' => [
                'nullable',
                'integer',
                'min:50',
                'max:5000',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
        ], [
            'image.required' => 'Please select at least one image.',
            'image.array' => 'Images must be uploaded as multiple files.',
            'image.min' => 'Please select at least one image.',
            'image.max' => 'You can upload maximum 20 images at once.',
            'image.*.required' => 'Each file must be a valid image.',
            'image.*.image' => 'Each file must be a valid image.',
            'image.*.mimes' => 'Each image must be JPG, JPEG, PNG, or WEBP.',
            'image.*.max' => 'Each image must not exceed 10MB.',

            'watermark.image' => 'The watermark must be a valid image.',
            'watermark.mimes' => 'Watermark must be PNG, JPG, JPEG, or WEBP.',
            'watermark.max' => 'Watermark must not exceed 2MB.',

            'text_content.max' => 'Watermark text cannot exceed 255 characters.',

            'text_color.regex' => 'Text color must be a valid hex color (e.g. #FF0000).',

            'text_size.integer' => 'Text size must be a number.',
            'text_size.min' => 'Text size must be at least 8px.',
            'text_size.max' => 'Text size cannot exceed 200px.',

            'position.required' => 'Please select a watermark position.',
            'position.in' => 'Invalid watermark position.',

            'opacity.required' => 'Please select watermark opacity.',
            'opacity.integer' => 'Opacity must be a number.',
            'opacity.min' => 'Opacity must be at least 10%.',
            'opacity.max' => 'Opacity cannot exceed 100%.',

            'watermark_size.required' => 'Please select watermark size.',
            'watermark_size.integer' => 'Watermark size must be a number.',
            'watermark_size.min' => 'Watermark size must be at least 5%.',
            'watermark_size.max' => 'Watermark size cannot exceed 100%.',

            'quality.required' => 'Please select image quality.',
            'quality.integer' => 'Quality must be a number.',
            'quality.min' => 'Quality must be at least 1.',
            'quality.max' => 'Quality cannot exceed 100.',

            'resize_width.integer' => 'Width must be a number.',
            'resize_width.min' => 'Width must be at least 50px.',
            'resize_width.max' => 'Width cannot exceed 5000px.',

            'resize_height.integer' => 'Height must be a number.',
            'resize_height.min' => 'Height must be at least 50px.',
            'resize_height.max' => 'Height cannot exceed 5000px.',

            'email.email' => 'Please enter a valid email address.',
        ]);

        $validated = $validator->validated();

        try {
            $imageDirectory = public_path('images');

            if (!File::exists($imageDirectory)) {
                File::makeDirectory($imageDirectory, 0755, true);
            }

            $position = $request->input('position', 'bottom-right');
            $opacity = (int) $request->input('opacity', 70);
            $watermarkSizePercent = (int) $request->input('watermark_size', 20);
            $isTiled = $request->has('is_tiled');
            $quality = (int) $request->input('quality', 90);
            $resizeWidth = $request->filled('resize_width') ? (int) $request->resize_width : null;
            $resizeHeight = $request->filled('resize_height') ? (int) $request->resize_height : null;
            $textContent = $request->filled('text_content') ? trim($request->text_content) : null;
            $textColor = $request->filled('text_color') ? $request->text_color : '#000000';
            $textSize = $request->filled('text_size') ? (int) $request->text_size : 24;
            $textFont = $request->filled('text_font') ? $request->text_font : 'arial';
            $email = $request->filled('email') ? $request->email : null;

            $watermarkPath = null;
            $hasLogoWatermark = $request->hasFile('watermark');

            if ($hasLogoWatermark) {
                $watermarkPath = $request->file('watermark')->getRealPath();
            } else {
                $defaultWatermark = public_path('logo.png');
                if (File::exists($defaultWatermark)) {
                    $watermarkPath = $defaultWatermark;
                }
            }

            $processedImages = [];
            $uploadedFiles = $request->file('image');

            foreach ($uploadedFiles as $uploadedFile) {
                $originalName = $uploadedFile->getClientOriginalName();
                $extension = strtolower($uploadedFile->getClientOriginalExtension());
                $imageName = time() . '_' . uniqid() . '.' . $extension;

                $img = Image::read($uploadedFile->getRealPath());

                /*
                 * Resize if requested
                 */
                if ($resizeWidth || $resizeHeight) {
                    if ($resizeWidth && $resizeHeight) {
                        $img->resize($resizeWidth, $resizeHeight, function ($c) {
                            $c->aspectRatio();
                        });
                    } elseif ($resizeWidth) {
                        $img->resize($resizeWidth, null, function ($c) {
                            $c->aspectRatio();
                        });
                    } elseif ($resizeHeight) {
                        $img->resize(null, $resizeHeight, function ($c) {
                            $c->aspectRatio();
                        });
                    }
                }

                /*
                 * Determine watermark type for history
                 */
                $watermarkType = 'none';
                if ($hasLogoWatermark && $textContent) {
                    $watermarkType = 'both';
                } elseif ($hasLogoWatermark) {
                    $watermarkType = 'logo';
                } elseif ($textContent) {
                    $watermarkType = 'text';
                }

                /*
                 * Apply text watermark
                 */
                if ($textContent) {
                    $textPos = $this->getTextPosition($position, $img->width(), $img->height());

                    $img->text(
                        $textContent,
                        $textPos['x'],
                        $textPos['y'],
                        function ($font) use ($textColor, $textSize, $textFont) {
                            $font->size($textSize);
                            $font->color($textColor);
                            $fontPath = $this->getFontPath($textFont);
                            if ($fontPath) {
                                $font->font($fontPath);
                            }
                        }
                    );
                }

                /*
                 * Apply logo watermark
                 */
                if ($watermarkPath && File::exists($watermarkPath)) {
                    $watermark = Image::read($watermarkPath);

                    $watermarkWidth = max(
                        20,
                        (int) round($img->width() * ($watermarkSizePercent / 100))
                    );

                    $watermarkWidth = min($watermarkWidth, $img->width());

                    $watermark->scale(width: $watermarkWidth);
                    $watermark->brightness(-10);

                    if ($isTiled) {
                        $this->applyTiledWatermark($img, $watermark, $opacity);
                    } else {
                        $padding = 20;
                        $img->place($watermark, $position, $padding, $padding, $opacity);
                    }
                }

                /*
                 * Save processed image with quality
                 */
                $img->save(
                    $imageDirectory . DIRECTORY_SEPARATOR . $imageName,
                    quality: $quality
                );

                $processedImages[] = $imageName;

                /*
                 * Save to history
                 */
                WatermarkHistory::create([
                    'filename' => $imageName,
                    'original_filename' => $originalName,
                    'watermark_type' => $watermarkType,
                    'position' => $position,
                    'opacity' => $opacity,
                    'watermark_size' => $watermarkSizePercent,
                    'is_tiled' => $isTiled,
                    'quality' => $quality,
                    'resize_width' => $resizeWidth,
                    'resize_height' => $resizeHeight,
                    'text_content' => $textContent,
                    'text_color' => $textColor,
                    'text_size' => $textSize,
                    'text_font' => $textFont,
                    'email' => $email,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            /*
             * Send email if requested
             */
            if ($email && !empty($processedImages)) {
                try {
                    Mail::to($email)->send(
                        new WatermarkedImageMail($processedImages, $imageDirectory)
                    );
                } catch (\Throwable $e) {
                    return redirect()
                        ->route('image.upload')
                        ->with('warning', 'Images processed successfully, but email could not be sent.')
                        ->with('image', $processedImages[0]);
                }
            }

            return redirect()
                ->route('image.upload')
                ->with('success', count($processedImages) . ' image(s) watermarked successfully!')
                ->with('image', $processedImages[0]);

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'image' =>
                        'Unable to process the image. Please make sure the uploaded files are valid images. Error: ' .
                        $e->getMessage(),
                ]);
        }
    }

    /**
     * Generate preview of watermarked image.
     */
    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'text_content' => [
                'nullable',
                'string',
                'max:255',
            ],
            'text_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'text_size' => [
                'nullable',
                'integer',
                'min:8',
                'max:200',
            ],
            'text_font' => [
                'nullable',
                'string',
                'max:50',
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
            'watermark_size' => [
                'required',
                'integer',
                'min:5',
                'max:100',
            ],
            'is_tiled' => [
                'sometimes',
                'accepted',
            ],
            'resize_width' => [
                'nullable',
                'integer',
                'min:50',
                'max:5000',
            ],
            'resize_height' => [
                'nullable',
                'integer',
                'min:50',
                'max:5000',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            $img = Image::read($request->file('image')->getRealPath());

            $position = $request->input('position', 'bottom-right');
            $opacity = (int) $request->input('opacity', 70);
            $watermarkSizePercent = (int) $request->input('watermark_size', 20);
            $isTiled = $request->has('is_tiled');
            $resizeWidth = $request->filled('resize_width') ? (int) $request->resize_width : null;
            $resizeHeight = $request->filled('resize_height') ? (int) $request->resize_height : null;
            $textContent = $request->filled('text_content') ? trim($request->text_content) : null;
            $textColor = $request->filled('text_color') ? $request->text_color : '#000000';
            $textSize = $request->filled('text_size') ? (int) $request->text_size : 24;
            $textFont = $request->filled('text_font') ? $request->text_font : 'arial';

            if ($resizeWidth || $resizeHeight) {
                if ($resizeWidth && $resizeHeight) {
                    $img->resize($resizeWidth, $resizeHeight, function ($c) {
                        $c->aspectRatio();
                    });
                } elseif ($resizeWidth) {
                    $img->resize($resizeWidth, null, function ($c) {
                        $c->aspectRatio();
                    });
                } elseif ($resizeHeight) {
                    $img->resize(null, $resizeHeight, function ($c) {
                        $c->aspectRatio();
                    });
                }
            }

            if ($textContent) {
                $textPos = $this->getTextPosition($position, $img->width(), $img->height());

                $img->text(
                    $textContent,
                    $textPos['x'],
                    $textPos['y'],
                    function ($font) use ($textColor, $textSize, $textFont) {
                        $font->size($textSize);
                        $font->color($textColor);
                        $fontPath = $this->getFontPath($textFont);
                        if ($fontPath) {
                            $font->font($fontPath);
                        }
                    }
                );
            }

            $watermarkPath = null;
            if ($request->hasFile('watermark')) {
                $watermarkPath = $request->file('watermark')->getRealPath();
            } else {
                $defaultWatermark = public_path('logo.png');
                if (File::exists($defaultWatermark)) {
                    $watermarkPath = $defaultWatermark;
                }
            }

            if ($watermarkPath && File::exists($watermarkPath)) {
                $watermark = Image::read($watermarkPath);

                $watermarkWidth = max(
                    20,
                    (int) round($img->width() * ($watermarkSizePercent / 100))
                );

                $watermarkWidth = min($watermarkWidth, $img->width());

                $watermark->scale(width: $watermarkWidth);
                $watermark->brightness(-10);

                if ($isTiled) {
                    $this->applyTiledWatermark($img, $watermark, $opacity);
                } else {
                    $padding = 20;
                    $img->place($watermark, $position, $padding, $padding, $opacity);
                }
            }

            $previewPath = sys_get_temp_dir() . '/watermark_preview_' . uniqid() . '.jpg';
            $img->save($previewPath, quality: 80);

            return response()->file($previewPath, [
                'Content-Type' => 'image/jpeg',
            ]);

        } catch (\Throwable $e) {
            return response()->json(['error' => 'Preview generation failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download processed image.
     */
    public function download($filename)
    {
        $filename = basename($filename);
        $path = public_path('images' . DIRECTORY_SEPARATOR . $filename);

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
        $path = public_path('images' . DIRECTORY_SEPARATOR . $filename);

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
     * Send watermarked image via email.
     */
    public function email($filename)
    {
        $filename = basename($filename);
        $path = public_path('images' . DIRECTORY_SEPARATOR . $filename);

        if (!File::exists($path)) {
            return redirect()
                ->route('image.upload')
                ->with('error', 'Image not found.');
        }

        $request = request();

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'max:255',
            ],
        ], [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            Mail::to($request->email)->send(
                new WatermarkedImageMail([$filename], public_path('images'))
            );

            return back()->with('success', 'Image sent to email successfully!');

        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    /**
     * View watermark history.
     */
    public function history()
    {
        $history = WatermarkHistory::orderByDesc('created_at')->paginate(20);

        return view('imageHistory', compact('history'));
    }

    /**
     * Delete history record.
     */
    public function destroyHistory($id)
    {
        $record = WatermarkHistory::findOrFail($id);
        $record->delete();

        return redirect()
            ->route('image.history')
            ->with('success', 'History record deleted successfully.');
    }

    /**
     * Apply tiled watermark across the entire image.
     */
    private function applyTiledWatermark($img, $watermark, int $opacity): void
    {
        $imgWidth = $img->width();
        $imgHeight = $img->height();
        $watermarkWidth = $watermark->width();
        $watermarkHeight = $watermark->height();

        $spacingX = (int) ($watermarkWidth * 0.5);
        $spacingY = (int) ($watermarkHeight * 0.5);

        for ($y = -$watermarkHeight; $y < $imgHeight; $y += $watermarkHeight + $spacingY) {
            for ($x = -$watermarkWidth; $x < $imgWidth; $x += $watermarkWidth + $spacingX) {
                $img->place($watermark, 'top-left', $x, $y, $opacity);
            }
        }
    }

    /**
     * Calculate text position based on position string.
     */
    private function getTextPosition(string $position, int $imgWidth, int $imgHeight): array
    {
        $padding = 30;

        switch ($position) {
            case 'top-left':
                return ['x' => $padding, 'y' => $padding + 24];

            case 'top-right':
                return ['x' => $imgWidth - $padding, 'y' => $padding + 24];

            case 'center':
                return ['x' => (int) ($imgWidth / 2), 'y' => (int) ($imgHeight / 2)];

            case 'bottom-left':
                return ['x' => $padding, 'y' => $imgHeight - $padding];

            case 'bottom-right':
                return ['x' => $imgWidth - $padding, 'y' => $imgHeight - $padding];

            default:
                return ['x' => $padding, 'y' => $padding + 24];
        }
    }

    /**
     * Format file size.
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return round($bytes / (1024 * 1024), 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Get font path for text watermark.
     */
    private function getFontPath(string $font): ?string
    {
        $fontPaths = [
            public_path('fonts/' . $font . '.ttf'),
            public_path('fonts/' . ucfirst($font) . '.ttf'),
            public_path($font . '.ttf'),
        ];

        foreach ($fontPaths as $path) {
            if (File::exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
