<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\DateMeet as Authenticatable;

class DateMeet extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // public $timestamps = true;
    protected $table = 'meet_date_time';
    protected $fillable = [
        'id_meet',
        'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id_meet',
    ];
}