<?php

declare(strict_types=1);

namespace App\JsonParser;

use App\JsonParser\Commands\ParseBooksResourceCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class JsonParserServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Manager::class,
            fn() => new Manager(config('json-parser'))
        );

//        $this->app->singleton(
//            PlainIntRandomizer::class,
//            fn() => new PlainIntRandomizer(config('game.random_int_min'), config('game.random_int_max'))
//        );

        $this->commands([
            ParseBooksResourceCommand::class,
        ]);
    }

    public function provides(): array
    {
        return [
            Manager::class,
//            PlainIntRandomizer::class,
        ];
    }
}
