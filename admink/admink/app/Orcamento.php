<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int     $id_orcamento
* @property string  $tatuagem_nome
* @property string  $tatuagem_local
* @property decimal $tatuagem_comprimento
* @property decimal $tatuagem_largura
* @property string  $tatuagem_descricao
* @property string  $tatuagem_referencias
* @property boolean $tatuagem_colorida
* @property boolean $tatuagem_autoral
* @property float   $valor
* @property string  $tempo_estimado
* @property string  $canal_contato
* @property string  $observacao
* @property boolean $aceite_termo
* @property int     $fk_cliente_id_cliente
* @property int     $fk_artista_id_artista
* @property int     $fk_uso_materiais_id_uso_materiais
* @property int     $fk_complexidade_id_complexidade
* @property int     $fk_estudio_id_estudio
* @property int     $fk_orcamento_status_id_orcamento_status
* @property string  $created_at
* @property string  $updated_at
* @property string  $deleted_at
*/

class Orcamento extends Model
{
    use SoftDeletes;
    
    protected $table = 'orcamento';

    protected $primaryKey = 'id_orcamento';

    protected $fillable = [
        'tatuagem_nome', 
        'tatuagem_local', 
        'tatuagem_comprimento', 
        'tatuagem_largura', 
        'tatuagem_descricao', 
        'tatuagem_referencias', 
        'tatuagem_colorida', 
        'tatuagem_autoral', 
        'valor', 
        'tempo_estimado', 
        'canal_contato', 
        'observacao', 
        'aceite_termo'
    ];

    public function complexidade()
    {
        return $this->belongsTo('App\Complexidade', 'fk_complexidade_id_complexidade');
    }

    public function uso_materiais()
    {
        return $this->belongsTo('App\UsoMateriais', 'fk_uso_materiais_id_uso_materiais');
    }

    public function orcamento_status()
    {
        return $this->belongsTo('App\OrcamentoStatus', 'fk_orcamento_status_id_orcamento_status');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'fk_cliente_id_cliente');
    }

    public function artista()
    {
        return $this->belongsTo('App\Artista', 'fk_artista_id_artista');
    }

    public function estudio()
    {
        return $this->belongsTo('App\Estudio', 'fk_estudio_id_estudio');
    }

    public function agendamento()
    {
        return $this->hasMany('App\Agendamento', 'fk_orcamento_id_orcamento', 'id_orcamento');
    }
}