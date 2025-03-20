<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raters extends Model
{
    protected $fillable = ['user_id', 'canRate'];

    protected $casts = [
        'canRate' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
