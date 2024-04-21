<?php

declare(strict_types=1);

namespace App\Validators;

use App\Models\ErrorModel;
use Rakit\Validation\Validator;

class PostValidator
{
    public function __construct(
        private Validator $validator
    ) {
    }

    public function validatePost(mixed $data): ?ErrorModel
    {
        $validation = $this->validator->make($data, [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:3|max:255',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            $errorModel = new ErrorModel(
                $validation->errors()->toArray(),
                'The given data was invalid.',
                422
            );
            return $errorModel;
        }

        return null;
    }

    public function validateUpdate(mixed $data): ?ErrorModel
    {
        $validation = $this->validator->make($data, [
            'id' => 'required|integer',
            'title' => 'min:3|max:255',
            'content' => 'min:3|max:255',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            $errorModel = new ErrorModel(
                $validation->errors()->toArray(),
                'The given data was invalid.',
                422
            );
            return $errorModel;
        }

        return null;
    }
}
