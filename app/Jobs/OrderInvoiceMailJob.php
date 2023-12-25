<?php

namespace App\Jobs;

use App\Mail\OrderInvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderInvoiceMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $products, $data, $address, $invoice;

    /**
     * @param $email
     * @param $products
     * @param $data
     * @param $address
     * @param $invoice
     */
    public function __construct($email, $products, $data, $address, $invoice)
    {
        $this->email = $email;
        $this->products = $products;
        $this->data = $data;
        $this->address = $address;
        $this->invoice = $invoice;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new OrderInvoiceMail($this->products, $this->data, $this->address, $this->invoice));
    }
}
