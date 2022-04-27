<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'room';
    protected $primaryKey = 'id_room';
    protected $fillable = [
        'name_room',
        'description',
        'isOnline',
        'isBooked',
        'user_id'
    ];
}
