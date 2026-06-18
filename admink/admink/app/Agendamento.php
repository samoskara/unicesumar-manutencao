<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int    $id_agendamento
 * @property int    $fk_orcamento_id_orcamento
 * @property int    $fk_estacao_id_estacao
 * @property string $data_horario_inicio
 * @property string $data_horario_fim
 * @property string $observacao
 * @property int    $fk_agendamento_status_id_agendamento_status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */

 class Agendamento extends Model
 {
    use SoftDeletes;
     
    protected $table = 'agendamento';

    protected $primaryKey = 'id_agendamento';

    protected $fillable = [
        'data_horario_inicio', 
        'data_horario_fim', 
        'observacao'
    ];

    protected $casts = [
        'data_horario_inicio' => 'datetime:Y-m-d H:i',
        'data_horario_fim' => 'datetime:Y-m-d H:i',
    ];

    public function agendamento_status()
    {
        return $this->belongsTo('App\AgendamentoStatus', 'fk_agendamento_status_id_agendamento_status');
    }

    public function estacao()
    {
        return $this->belongsTo('App\Estacao', 'fk_estacao_id_estacao');
    }

    public function orcamento()
    {
        return $this->belongsTo('App\Orcamento', 'fk_orcamento_id_orcamento');
    }
}
