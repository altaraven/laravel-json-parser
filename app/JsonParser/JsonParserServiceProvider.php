<?php

declare(strict_types=1);

namespace App\JsonParser;

use App\JsonParser\Commands\ParseBooksResourceCommand;
use Illuminate\Support\ServiceProvider;

class JsonParserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Manager::class,
            fn($app) => new Manager($app['config']['parsers'])
        );

        $this->app->singleton('parser:books', fn($app) => new Parsers\BooksParser($app['config']['parsers']['books']));

        $this->commands([
            ParseBooksResourceCommand::class,
        ]);
    }
}
