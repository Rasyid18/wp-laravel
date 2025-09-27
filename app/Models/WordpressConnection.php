<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordpressConnection extends Model
{
    protected $fillable = ['name', 'host', 'port', 'database', 'username', 'password', 'prefix', 'active'];
}
