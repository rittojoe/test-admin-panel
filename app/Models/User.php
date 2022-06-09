<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent 
{

    protected $connection   =   'mysql';
    protected $table        =   'user';
    protected $fillable     =   ['id',
                                 'email',
                                 'password',
                                ];
    public $timestamps      =    false;

    protected $hidden = [
        'password'
    ];

}

?>