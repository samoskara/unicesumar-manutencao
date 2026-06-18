<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int    $id_agendamento_status
* @property string $status
* @property string $created_at
* @property string $updated_at
* @property string $deleted_at
*/

class AgendamentoStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'agendamento_status';

    protected $primaryKey = 'id_agendamento_status';

    protected $fillable = ['status'];

    public function agendamento()
    {
        return $this->hasMany('App\Agendamento', 'fk_agendamento_status_id_agendamento_status', 'id_agendamento_status');   
    }
}