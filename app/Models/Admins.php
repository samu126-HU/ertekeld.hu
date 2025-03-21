<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $fillable = ['user_id', 'adminLevel'];

    protected $casts = [
        'adminLevel' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Admin level constants
    public const NORMAL_USER = 0;
    public const MODERATOR = 1;
    public const ADMIN = 2;
}
