<?php

declare(strict_types=1);

namespace App\Models;

class ErrorModel
{
    public array $errors;
    public string $message;
    public int $code;

    public function __construct(array $errors, string $message, int $code)
    {
        $this->errors = $errors;
        $this->message = $message;
        $this->code = $code;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'errors' => $this->errors,
        ];
    }

}
