<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int     $id_cliente_estudio
 * @property boolean $ativo
 * @property int     $fk_estudio_id_estudio
 * @property int     $fk_cliente_id_cliente
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $deleted_at
 */

 class ClienteEstudio extends Pivot
 {
    use SoftDeletes;
    
    protected $table = 'cliente_estudio';

    protected $primaryKey = 'id_cliente_estudio';

    protected $fillable = [
        'ativo',
        'fk_estudio_id_estudio',
        'fk_cliente_id_cliente'
    ];
}