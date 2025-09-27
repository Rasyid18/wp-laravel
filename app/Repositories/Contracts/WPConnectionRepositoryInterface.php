<?php

namespace App\Repositories\Contracts;

use App\Models\WordpressConnection;

interface WPConnectionRepositoryInterface
{
    public function getConnection(): ?WordpressConnection;
    public function updateConnection(array $param): WordpressConnection;
}
