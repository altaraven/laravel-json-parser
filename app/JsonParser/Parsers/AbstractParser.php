<?php

namespace App\JsonParser\Parsers;

abstract class AbstractParser
{
    public function __construct(protected array $config = [])
    {
    }
}
