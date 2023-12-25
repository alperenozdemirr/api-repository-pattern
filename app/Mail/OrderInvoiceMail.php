<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $products, $data, $address, $invoice;

    /**
     * @param $products
     * @param $data
     */
    public function __construct($products, $data, $address, $invoice)
    {
        $this->products = $products;
        $this->data = $data;
        $this->address = $address;
        $this->invoice = $invoice;
    }

    /**
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sipariş Faturanız',
        );
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-invoice',
            with: [
                'products' => $this->products,
                'data' => $this->data,
                'address' => $this->address,
                'invoice' => $this->invoice,
            ],
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
