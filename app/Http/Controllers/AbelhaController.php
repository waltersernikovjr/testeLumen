<?php

namespace App\Http\Controllers;

use App\Models\Abelha;
use Exception;
use Illuminate\Http\Request;

class AbelhaController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'especie' => 'required'
        ]);

        $abelha = new Abelha();

        $abelha->nome = $request->input('nome');
        $abelha->especie = $request->input('especie');

        if ($abelha->save()) {
            return response()->json(array('success' => true, 'id' => $abelha->id));
        }
        return response()->json(array('success' => false, 'error' => 'Erro ao cadastrar Abelha'));
    }


    public function listAll()
    {
        try {
            $abelhas = Abelha::all();

            return response()->json(array('success' => true, 'abelhas' => $abelhas));
        } catch (Exception $e) {
            return response()->json(array('success' => false, 'erro' => $e->getMessage()));
        }
    }

    public function getByBusca(Request $request)
    {

        $this->validate($request, [
            'busca' => 'required'
        ]);

        $abelhas = new Abelha();

        $abelhas = $abelhas->getByBusca($request->input('busca'));

        if (!is_string($abelhas)) {
            return response()->json(array('success' => true, 'abelhas' => $abelhas));
        }

        return response()->json(array('success' => false, 'erro' => $abelhas));
    }
}
