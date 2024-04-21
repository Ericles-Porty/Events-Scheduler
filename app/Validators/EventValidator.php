<?php

declare(strict_types=1);

namespace App\Validators;

use App\Models\ErrorModel;
use Rakit\Validation\Validator;

class EventValidator
{
    public function __construct(
        private Validator $validator
    ) {
    }

    public function validateStore(mixed $data): ?ErrorModel
    {

        $validation = $this->validator->make($data, [
            'title' => 'required|min:3|max:255',
            'details' => 'nullable|min:3',
            'maximum_attendees' => 'nullable|integer'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return new ErrorModel(
                errors: $validation->errors()->toArray(),
                message: 'Validation error',
                code: 422,
            );
        }

        return null;
    }
}
