<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Flor extends Model
{
    protected $table = 'flores';
    protected $fillable = [
        'nome', 'especie', 'imagem', 'descricao'
    ];

    public function getByFilter($filtros){

        try{

            $query = Flor::select('flores.id','flores.nome','flores.especie','flores.imagem')->join('flores_meses','flores_meses.flor_id','=','flores.id')
        ->join('flores_abelhas','flores_abelhas.flor_id','flores.id');

        if(isset($filtros->meses) && !empty($filtros->meses)){
            $query = $query->whereIn('flores_meses.mes',$filtros->meses);
        }

        if(isset($filtros->abelhas) && !empty($filtros->abelhas)){
            $query = $query->whereIn('flores_abelhas.abelha_id',$filtros->abelhas);
        }

        return $query->distinct()->get();

        }catch(Exception $e){
            return $e->getMessage();
        }
        

    }

    public function getById($id){
        try{
            return Flor::select('flores.id','flores.nome','flores.especie','flores.imagem')->where('id','=',$id)->first();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
}
