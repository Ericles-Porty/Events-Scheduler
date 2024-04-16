<?php

namespace App\Repositories;

interface IRepository
{
    public function all(): array;
    public function find($id): object | null;
    public function create($data): object;
    public function update($id, $newData): object;
    public function delete($id): void;
}
