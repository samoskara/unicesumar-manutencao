<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int      $id_artista_estudio
 * @property string  $data_inicio
 * @property string  $data_fim
 * @property boolean $ativo
 * @property boolean $visitante
 * @property int     $fk_estudio_id_estudio
 * @property int     $fk_artista_id_artista
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $deleted_at
 */

 class ArtistaEstudio extends Pivot
 {
    use SoftDeletes;
     
    protected $table = 'artista_estudio';
     
    protected $primaryKey = 'id_artista_estudio';

    protected $casts = [
        'data_inicio' => 'datetime:Y-m-d',
        'data_fim' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'data_inicio', 
        'data_fim', 
        'ativo', 
        'visitante'
    ];
}