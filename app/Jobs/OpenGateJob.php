<?php

namespace App\Jobs;

use App\Clients\NovofonClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class OpenGateJob implements ShouldQueue
{
    use Queueable;

    private const TIMEOUT_ADD_NUMBER = 4;

    private $createdAt;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private int $phoneNumber
    ) {
        $this->createdAt = Carbon::now(); // Сохраняем время постановки задачи
    }

    /**
     * Execute the job.
     */
    public function handle(NovofonClient $novofonClient): void
    {
        //Если таймаут больше self::TIMEOUT_ADD_NUMBER, то не отправляем в API novofon
        if ($this->createdAt->diffInSeconds(Carbon::now()) > self::TIMEOUT_ADD_NUMBER) {
            return;
        }

        $novofonClient->requestCheckNumber($this->phoneNumber);
    }
}
