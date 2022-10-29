<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
  * Esta clase es la utilizada para definir el tipo de usuario qeu es.
  * @author NetCode Solutions solutionsnetcode@gmail.com
*/
class TipoUsuario extends Model
{
    protected $table = 'TiposUsuario';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo', ''
    ];

}
