<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int     $id_estacao
* @property string  $identificacao
* @property boolean $ativa
* @property int     $fk_estudio_id_estudio
* @property string  $created_at
* @property string  $updated_at
* @property string  $deleted_at
*/

class Estacao extends Model
{
    use SoftDeletes;
    
    protected $table = 'estacao';

    protected $primaryKey = 'id_estacao';

    protected $fillable = [
        'identificacao',
        'ativa'
    ];

    public function estudio()
    {
        return $this->belongsTo('App\Estudio', 'fk_estudio_id_estudio');
    }

    public function agendamento()
    {
        return $this->hasMany('App\Agendamento', 'fk_estacao_id_estacao', 'id_estacao');
    }
}