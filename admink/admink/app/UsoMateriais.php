<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int $id_uso_materiais
* @property string $nivel
* @property string $created_at
* @property string $updated_at
* @property string $deleted_at
*/

class UsoMateriais extends Model
{
    use SoftDeletes;
    
    protected $table = 'uso_materiais';
    
    protected $primaryKey = 'id_uso_materiais';

    protected $fillable = ['nivel'];

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_uso_materiais_id_uso_materiais', 'id_uso_materiais');
    }
}