<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\WordpressModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMeta extends WordpressModel
{
    protected $table = 'usermeta';
    protected $primaryKey = 'umeta_id';

    protected $fillable = ['user_id', 'meta_key', 'meta_value'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "user_id", "ID");
    }
}
