<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int    $id_cliente
 * @property string $nome
 * @property string $email
 * @property string $telefone
 * @property string $apelido
 * @property string $data_nascimento
 * @property string $observacao
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */

 class Cliente extends Model
 {
    use SoftDeletes;
     
    protected $table = 'cliente';

    protected $primaryKey = 'id_cliente';

    protected $casts = [
        'data_nascimento' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'apelido',
        'data_nascimento',
        'observacao'
    ];

    public function estudio()
    {
        return $this->belongsToMany('App\Estudio', 'cliente_estudio', 'fk_cliente_id_cliente', 'fk_estudio_id_estudio')->using('App\ClienteEstudio')->withPivot('ativo')->withTimestamps();
    }

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_cliente_id_cliente', 'id_cliente');
    }
}