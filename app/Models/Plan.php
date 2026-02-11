<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\GymScope;
use Illuminate\Support\Facades\Auth;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'duration_days',
        'price',
    ];

    /**
     * The "booted" method allows us to automatically attach 
     * the Gym ID whenever a plan is created.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new GymScope);

        static::creating(function ($plan) {
            if (Auth::check()) {
                $plan->gym_id = Auth::user()->gym_id;
            }
        });
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
    
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}