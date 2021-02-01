<?php

use App\Models\Flor;
use App\Models\Abelha;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FlorTest extends TestCase
{


    use DatabaseTransactions;


    /**
     * Teste para verificar se os campos da model estão iguais ao do BD.
     *
     * @return void
     */

    public function testColumnsOK()
    {
        $flor = new Flor();

        $esperado = array('nome', 'especie', 'imagem', 'descricao');

        $comparacao = array_diff($esperado, $flor->getFillable());


        $this->assertEquals(0, count($comparacao));
    }


    /**
     * Teste para verificar retorno getbyid .
     *
     * @return void
     */
    public function testGetByIdOK()
    {

        $flor = new Flor();
        $abelha = new Abelha();


        $flor = $flor->getById(1);

        $flor->imagem = url('/') . $flor->imagem;

        $this->json('GET', '/buscaFlor', ["id" => 1])
            ->seeJsonEquals([
                "success" => true,
                "flor" => $flor,
                "abelhas" => $abelha->getByFlor(1)
            ]);
        $this->assertEquals(200, $this->response->status());
    }


    /**
     * Teste para retorno por filtro
     * 
     * @return void
     */

    public function testFiltroOK()
    {

        $flores = new Flor();

        $flores = $flores->getByFilter([]);

        $flores = $flores->map(function ($flor) {
            $flor->imagem = url('/') . $flor->imagem;
            return $flor;
        }, $flores);

        $this->json('GET', '/buscaFlores', [])
            ->seeJsonEquals([
                "success" => true,
                "flores" => $flores
            ]);
        $this->assertEquals(200, $this->response->status());
    }
}
