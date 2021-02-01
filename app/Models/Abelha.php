<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Abelha extends Model
{

    protected $table = 'abelhas';
    protected $fillable = [
        'nome', 'especie',
    ];



    public function getByBusca($nome){
        try{

            return Abelha::orWhere('nome','like','%'.$nome.'%')->orWhere('especie','like','%'.$nome.'%')->get();

        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    public function getByFlor($flor_id){
        try{
            return Abelha::select('id','nome','especie')->join('flores_abelhas','flores_abelhas.abelha_id','=','abelhas.id')
            ->where('flores_abelhas.flor_id','=',$flor_id)->get();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
