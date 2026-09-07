<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WatermarkedImageMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $images;
    public string $imageDirectory;

    public function __construct(array $images, string $imageDirectory)
    {
        $this->images = $images;
        $this->imageDirectory = $imageDirectory;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Watermarked Image' . (count($this->images) > 1 ? 's' : ''),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.watermarked',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->images as $image) {
            $path = $this->imageDirectory . DIRECTORY_SEPARATOR . $image;

            if (file_exists($path)) {
                $attachments[] = Attachment::fromPath($path)
                    ->as($image)
                    ->withMime(
                        match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
                            'png' => 'image/png',
                            'webp' => 'image/webp',
                            default => 'image/jpeg',
                        }
                    );
            }
        }

        return $attachments;
    }
}
