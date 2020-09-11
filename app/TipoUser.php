<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUser extends Model
{

    protected $table = 'tipos_user';
    protected $guarded = ['id'];
    protected $fillable = [
        'descripcion', 'created_at', 'updated_at'
    ];

}
