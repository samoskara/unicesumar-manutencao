<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int $id_estudio_users
* @property boolean $ativo
* @property string $data_inicio
* @property string $data_fim
* @property int $fk_users_id_users
* @property int $fk_estudio_id_estudio
*/

class EstudioUsers extends Pivot
{
    use SoftDeletes;
    
    protected $table = 'estudio_users';

    protected $primaryKey = 'id_estudio_users';

    protected $fillable = [
        'ativo',
        'data_inicio',
        'data_fim',
        'fk_users_id_users',
        'fk_estudio_id_estudio'
    ];
}