<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloresAbelhas extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'flor_id', 'mes'
    ];
}
