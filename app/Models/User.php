<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasRole(array $roles): bool {
        return in_array($this->role, $roles);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
