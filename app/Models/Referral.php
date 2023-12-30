<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'reward_type',
        'reward_value',
        'expiration_date',
    ];
}
