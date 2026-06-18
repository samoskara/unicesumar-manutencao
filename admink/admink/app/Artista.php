<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int     $id_artista
 * @property string $nome
 * @property string $apelido
 * @property string $email
 * @property string $telefone
 * @property string $data_nascimento
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */

 class Artista extends Model
 {
    use SoftDeletes;

    protected $table = 'artista';
    
    protected $primaryKey = 'id_artista';

    protected $casts = [
        'data_nascimento' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'nome',
        'apelido',
        'email',
        'telefone',
        'data_nascimento'
    ];

    public function estudio()
    {
        return $this->belongsToMany('App\Estudio', 'artista_estudio', 'fk_artista_id_artista', 'fk_estudio_id_estudio')->using('App\ArtistaEstudio')->withPivot('data_inicio', 'data_fim', 'ativo', 'visitante')->withTimestamps();
    }

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_artista_id_artista', 'id_artista');
    }
}