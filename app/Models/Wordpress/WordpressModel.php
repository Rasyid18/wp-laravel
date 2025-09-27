<?php

namespace App\Models\Wordpress;

use App\Models\WordpressConnection;
use Illuminate\Database\Eloquent\Model;

class WordpressModel extends Model
{
    protected $connection = 'wordpress_temp';
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        $conn = WordpressConnection::firstOrFail();

        config([
            'database.connections.wordpress_temp' => [
                'driver'   => 'mysql',
                'host'     => $conn->host,
                'port'     => $conn->port,
                'database' => $conn->database,
                'username' => $conn->username,
                'password' => $conn->password,
                'charset'  => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'   => $conn->prefix ?? 'wp_',
                'strict'   => false,
            ],
        ]);
    }
}
