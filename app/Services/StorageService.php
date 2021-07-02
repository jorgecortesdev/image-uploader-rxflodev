<?php

namespace App\Services;

interface StorageService
{
    public function all(): array;
    public function save(array $images): array;
    public function delete(int $id): bool;
}
