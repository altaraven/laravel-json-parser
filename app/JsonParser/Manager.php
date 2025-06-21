<?php

declare(strict_types=1);

namespace App\JsonParser;

use App\Exceptions\InvalidConfigurationException;
use App\JsonParser\Parsers\ParserInterface;

readonly class Manager
{
    public function __construct(
        private array $config
    ) {
    }

    public function parseResource(string $name): void
    {
        $this->getParser($name)->parseResource();
    }

    private function getParser(string $name): ParserInterface
    {
        $name = strtolower($name);
        if (!isset($this->config[$name])) {
            throw new InvalidConfigurationException("Unknown parser '{$name}'.");
        }

        return app('parser:' . $name);
    }
}
