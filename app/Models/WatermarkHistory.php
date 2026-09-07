<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatermarkHistory extends Model
{
    protected $table = 'watermark_history';

    protected $fillable = [
        'filename',
        'original_filename',
        'watermark_type',
        'position',
        'opacity',
        'watermark_size',
        'is_tiled',
        'quality',
        'resize_width',
        'resize_height',
        'text_content',
        'text_color',
        'text_size',
        'text_font',
        'email',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_tiled' => 'boolean',
        'opacity' => 'integer',
        'watermark_size' => 'integer',
        'quality' => 'integer',
        'resize_width' => 'integer',
        'resize_height' => 'integer',
        'text_size' => 'integer',
    ];
}
