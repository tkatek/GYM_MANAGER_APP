<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
    'name',
    'owner_name',
    'phone',
    'email',
];

// A gym has many users (owners/staff)
public function users()
{
    return $this->hasMany(User::class);
}

// A gym has many members
public function members()
{
    return $this->hasMany(Member::class);
}
}
