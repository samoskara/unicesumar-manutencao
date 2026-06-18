<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int    $id_orcamento_status
* @property string $status
* @property string $created_at
* @property string $updated_at
* @property string $deleted_at
*/

class OrcamentoStatus extends Model
{
    use SoftDeletes;
    
    protected $table = 'orcamento_status';

    protected $primaryKey = 'id_orcamento_status';

    protected $fillable = ['status'];

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_orcamento_status_id_orcamento_status', 'orcamento_status');
    }
}