<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int    $id_estudio
* @property string $nome
* @property string $endereco
* @property string $created_at
* @property string $updated_at
* @property string $deleted_at
* @property EstudioUsers[]   $estudio_users
* @property ClienteEstudio[] $clienteEstudio
* @property Estacao[]        $estacao
* @property Orcamento[]      $orcamento
* @property ArtistaEstudio[] $artista_estudio
*/

class Estudio extends Model
{
    use SoftDeletes;
    
    protected $table = 'estudio';

    protected $primaryKey = 'id_estudio';

    protected $fillable = ['nome', 'endereco'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'estudio_users', 'fk_estudio_id_estudio', 'fk_users_id_users')->using('App\EstudioUsers');
    }

    public function estacao()
    {
        return $this->hasMany('App\Estacao', 'fk_estudio_id_estudio', 'id_estudio');
    }

    public function cliente()
    {
        return $this->belongsToMany('App\Cliente', 'cliente_estudio', 'fk_estudio_id_estudio', 'fk_cliente_id_cliente')->using('App\ClienteEstudio');
    }

    public function artista()
    {
        return $this->belongsToMany('App\Artista', 'artista_estudio', 'fk_estudio_id_estudio', 'fk_artista_id_artista')->using('App\ArtistaEstudio');
    }

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_estudio_id_estudio', 'id_estudio');
    }    
}