<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloresMeses extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'flor_id', 'abelha_id'
    ];
}
