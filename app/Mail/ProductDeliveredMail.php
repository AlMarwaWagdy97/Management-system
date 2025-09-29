<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $orderId;
    public $productName;

     /**
     * Create a new message instance.
     */
    public function __construct($order, $subject = "تم توصيل الطلب", $message = "")
    {
        $this->orderId = $order->id;
        $this->productName = $order->item_name;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.product-confirmed',
            with:[
                'message' => $this->message,
                'productName' => $this->productName,
                'url' => route('site.review.save-order', $this->orderId),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
