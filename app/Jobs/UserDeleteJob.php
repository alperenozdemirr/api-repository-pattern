<?php

namespace App\Jobs;

use App\Http\Repositories\Admin\UserRepository;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    /**
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $userRepository = new UserRepository();
            $user =  $userRepository->find($this->userId);
            $user->delete();
        }catch (\Exception $e){
            Log::error('User delete failed: ' . $e->getMessage());
        }
    }
}
