<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\WordpressModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends WordpressModel
{
    protected $table = 'users';
    protected $primaryKey = 'ID';

    protected $fillable = ['user_login', 'user_pass', 'user_nicename', 'user_email', 'user_url', 'user_registered', 'user_activation_key', 'user_status', 'display_name'];

    public function meta(): HasMany
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID');
    }
}
