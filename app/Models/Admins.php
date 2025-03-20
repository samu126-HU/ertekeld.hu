<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $fillable = ['user_id', 'isAdmin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
