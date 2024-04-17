<?php

namespace App\Services;

interface LoggerServiceInterface
{
    public function send(string $index, string $level, string $message, array $data = []): void;
}
