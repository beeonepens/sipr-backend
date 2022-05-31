<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'team_member';
    // public $timestamps = false;
    protected $fillable = [
        'id_team',
        'id_member',
    ];
}
