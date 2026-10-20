<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class AddSticker extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $stickerData)
    {
        
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: __('Sticker addition request')
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.sticker-addition-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $uploaded = Arr::get($this->stickerData, 'image');
        if($uploaded instanceof UploadedFile) {
            return [
                Attachment::fromPath($uploaded->getPathName())
                ->as($uploaded->getClientOriginalName())
                ->withMime($uploaded->getClientMimeType())
            ];
        } else {
            return [];
        }      
    }
}
