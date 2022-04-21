<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Meet as Authenticatable;

class Meet extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'meet';

    protected $fillable = [
        'name_meeting',
        'description',
        'limit',
        'isOnline',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'limit',
    ];
}
