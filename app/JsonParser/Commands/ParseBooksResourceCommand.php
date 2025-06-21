<?php

namespace App\JsonParser\Commands;

use App\JsonParser\Jobs\ParseBooksResourceJob;
use Illuminate\Console\Command;

class ParseBooksResourceCommand extends Command
{
    protected $signature = 'app:parse-resource:books';

    protected $description = 'Opens url, parses books json data and saves it to the database';

    public function handle()
    {
        dispatch(new ParseBooksResourceJob());
    }
}
