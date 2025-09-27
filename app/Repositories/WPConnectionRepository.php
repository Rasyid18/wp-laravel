<?php

namespace App\Repositories;

use App\Models\WordpressConnection;
use App\Repositories\Contracts\WPConnectionRepositoryInterface;

class WPConnectionRepository implements WPConnectionRepositoryInterface
{
    protected WordpressConnection $connection;

    public function __construct(WordpressConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): ?WordpressConnection
    {
        return $this->connection->first();
    }

    public function updateConnection(array $param): WordpressConnection
    {
        $connection = $this->connection->first();
        if (!$connection) {
            $connection = $this->connection->create(array_merge($param, [
                'name' => $param['host'],
                'active' => true,
            ]));
        } else {
            $connection->update($param);
        }

        return $connection;
    }
}
