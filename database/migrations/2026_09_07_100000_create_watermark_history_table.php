<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watermark_history', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('watermark_type')->default('logo');
            $table->string('position')->default('bottom-right');
            $table->integer('opacity')->default(70);
            $table->integer('watermark_size')->default(20);
            $table->boolean('is_tiled')->default(false);
            $table->integer('quality')->default(90);
            $table->integer('resize_width')->nullable();
            $table->integer('resize_height')->nullable();
            $table->string('text_content')->nullable();
            $table->string('text_color')->default('#000000');
            $table->integer('text_size')->default(24);
            $table->string('text_font')->default('arial');
            $table->string('email')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index('filename');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watermark_history');
    }
};
