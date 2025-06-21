<?php

namespace App\JsonParser\Jobs;

use App\JsonParser\Manager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ParseBooksResourceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Manager $manager): void
    {
        $manager->parseBooksResource();
    }
}
