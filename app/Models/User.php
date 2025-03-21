<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Raters;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function rater()
    {
        return $this->hasOne(Raters::class)->withDefault([
            'canRate' => false,
        ]);
    }

    public function canRate()
    {
        return $this->rater?->canRate ?? false;
    }

    public function admin() {
        return $this->hasOne(Admins::class)->withDefault([
            'adminLevel' => Admins::NORMAL_USER,
        ]);
    }

    public function isAdmin()
    {
        return $this->admin?->adminLevel ?? Admins::NORMAL_USER;
    }

    public function isModerator()
    {
        return $this->isAdmin() >= Admins::MODERATOR;
    }

    public function isFullAdmin()
    {
        return $this->isAdmin() >= Admins::ADMIN;
    }
}
