<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'invitations';
    protected $primaryKey = 'id_invitation';
    protected $fillable = [
        'isAccepted',
        'reason',
        'expiredDateTime',
        'id_invitee',
        'id_receiver',
        'id_meet'
    ];
}
