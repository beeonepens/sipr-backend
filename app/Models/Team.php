<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'id_team';
    protected $fillable = [
        'name_teams',
        'description',
        'team_invite_code',
        'id_pembuat',
    ];
}
