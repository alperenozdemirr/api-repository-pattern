<?php

namespace App\Jobs;

use App\Http\Repositories\User\OrderDetailRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $orderId;
    protected $userId;
    public function __construct($orderId,$userId)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $orderDetailRepository = new OrderDetailRepository();
            $orderDetailRepository->createV2($this->orderId,$this->userId);
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
        }

    }
}
