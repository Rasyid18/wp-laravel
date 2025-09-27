<?php

namespace App\Repositories\Contracts\Wordpress;

use App\Models\Wordpress\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getUsers(int $rpp): LengthAwarePaginator;
    public function findByID(int|string $id): ?User;
    public function create(array $param): User;
    public function update(int|string $id, array $param): ?User;
    public function delete(int|string $id): bool;

    public function isUsernameTaken(string $username, int|string|null $excludeId = null): bool;
    public function isEmailTaken(string $email, int|string|null $excludeId = null): bool;
}
