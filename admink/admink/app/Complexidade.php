<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property int    $id_complexidade
* @property string $nivel
* @property string $created_at
* @property string $updated_at
* @property string $deleted_at
*/

class Complexidade extends Model
{
    use SoftDeletes;
    
    protected $table = 'complexidade';
    
    protected $primaryKey = 'id_complexidade';

    protected $fillable = ['nivel'];

    public function orcamento()
    {
        return $this->hasMany('App\Orcamento', 'fk_complexidade_id_complexidade', 'id_complexidade');
    }
}