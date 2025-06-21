<?php

namespace App\JsonParser\Jobs;

use App\JsonParser\Manager;
use App\JsonParser\Parsers\BooksParser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ParseBooksResourceJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(Manager $manager): void
    {
        $manager->parseResource(BooksParser::NAME);
    }
}
