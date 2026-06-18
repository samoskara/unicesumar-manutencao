<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function estudio()
    {
        return $this->belongsToMany('App\Estudio', 'estudio_users', 'fk_users_id_users', 'fk_estudio_id_estudio')->using('App\EstudioUsers')->withPivot('data_inicio', 'data_fim', 'ativo')->withTimestamps();
    }
}