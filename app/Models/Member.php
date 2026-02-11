<?php

namespace App\Models;

use App\Models\Scopes\GymScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'plan_id', // Changed from plan_type
        'name',
        'phone',
        'start_date',
        'end_date',
        'status',
        'price'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new GymScope);

        static::creating(function ($member) {
            if (Auth::check()) {
                $member->gym_id = Auth::user()->gym_id;
            }
        });
    }

    // Link to the Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}