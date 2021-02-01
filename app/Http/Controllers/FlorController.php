<?php

namespace App\Http\Controllers;

use App\Models\Abelha;
use App\Models\Flor;
use App\Models\FloresAbelhas;
use App\Models\FloresMeses;
use Exception;
use Illuminate\Http\Request;

class FlorController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'nome' => 'required',
            'especie' => 'required',
            'descricao' => 'required',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meses' => 'required|array',
            'meses.*' => 'integer|min:1|max:12',
            'abelhas' => 'required|array',
            'abelhas.*' => 'exists:abelhas,id'
        ]);

        $flor = new Flor();

        $nomeOriginal = $request->file('imagem')->getClientOriginalName();


        $arrayNomeOriginal = explode('.', $nomeOriginal);
        $extensaoImagem = end($arrayNomeOriginal);
        $destinoArquivo = './upload/flor/';
        $imagem = 'f-' . time() . '.' . $extensaoImagem;

        if ($request->file('imagem')->move($destinoArquivo, $imagem)) {
            $flor->imagem = '/upload/flor/' . $imagem;
        } else {
            return response()->json(array('success' => false, 'error' => 'Erro ao salvar a imagem, verifique as permissões de pasta'), 500);
        }

        $flor->nome = $request->input('nome');
        $flor->especie = $request->input('especie');
        $flor->descricao = $request->input('descricao');

        if ($flor->save()) {

            foreach ($request->input('meses') as $mes) {
                $florMes = new FloresMeses();
                $florMes->flor_id = $flor->id;
                $florMes->mes = $mes;

                if (!$florMes->save())
                    return response()->json(array('success' => false, 'error' => 'Erro ao salvar os meses de florada no banco'), 500);
            }

            foreach ($request->input('abelhas') as $abelha) {
                $florAbelha = new FloresAbelhas();
                $florAbelha->flor_id = $flor->id;
                $florAbelha->abelha_id = $abelha;

                if (!$florAbelha->save())
                    return response()->json(array('success' => false, 'error' => 'Erro ao salvar abelhas que polinizam a flor no banco'), 500);
            }

            return response()->json(array('success' => true, 'id' => $flor->id), 200);
        } else {
            return response()->json(array('success' => false, 'error' => 'Erro ao salvar a flor no banco'), 500);
        }
    }


    public function getByFilter(Request $request)
    {
        $this->validate($request, [
            'meses' => 'array',
            'meses.*' => 'integer|min:1|max:12',
            'abelhas' => 'array',
            'abelhas.*' => 'exists:abelhas,id'
        ]);


        $flores = new Flor();

        $flores = $flores->getByFilter($request);

        if (!is_string($flores)) {

            $flores = $flores->map(function ($flor) {
                $flor->imagem = url('/') . $flor->imagem;
                return $flor;
            }, $flores);

            return response()->json(array('success' => true, 'flores' => $flores));
        }

        return response()->json(array('success' => false, 'erro' => $flores));
    }


    public function getById(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:flores,id'
        ]);


        $flor = new Flor();

        $flor = $flor->getById($request->input('id'));

        if (is_string($flor)) {

            return response()->json(array('success' => false, 'erro' => $flor));
        }

        $flor->imagem = url('/') . $flor->imagem;

        $abelhas = new Abelha();

        $abelhas = $abelhas->getByFlor($request->input('id'));

        if (is_string($abelhas)) {

            return response()->json(array('success' => false, 'erro' => $abelhas));
        }


        return response()->json(array('success' => true, 'flor' => $flor, 'abelhas' => $abelhas));
    }
}
