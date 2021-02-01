<?php

use App\Models\Abelha;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AbelhaTest extends TestCase
{

    use DatabaseTransactions;


    /**
     * Teste para verificar se os campos da model estão iguais ao do BD.
     *
     * @return void
     */

    public function testColumnsOK()
    {
        $abelha = new Abelha();

        $esperado = array('nome', 'especie');

        $comparacao = array_diff($esperado, $abelha->getFillable());


        $this->assertEquals(0, count($comparacao));
    }


    /**
     * Teste para verificar se o cadastro esta correto.
     *
     * @return void
     */

    public function testStoreAbelhaOK()
    {
        $this->post('/cadastrarAbelha', ['nome' => 'Teste', 'especie' => 'teste'])
            ->seeJsonEquals([
                'success' => true,
                'id' => Abelha::latest()->first()->id
            ]);

        $this->assertEquals(200, $this->response->status());
    }


    /**
     * Teste para verificar se o quando o cadastro não recebe o parametro nome.
     *
     * @return void
     */

    public function testStoreAbelhaMissingNome()
    {
        $this->post('/cadastrarAbelha', ['nome' => '', 'especie' => 'teste'])
            ->seeJsonEquals([
                "nome" => [
                    "O campo nome é obrigatório."
                ]
            ]);
    }


    /**
     * Teste para verificar se o quando o cadastro não recebe o parametro nome.
     *
     * @return void
     */

    public function testStoreAbelhaMissingEspecie()
    {
        $this->post('/cadastrarAbelha', ['nome' => 'teste', 'especie' => ''])
            ->seeJsonEquals([
                "especie" => [
                    "O campo especie é obrigatório."
                ]
            ]);
    }

    /**
     * Teste que verifica o retorno de todas as abelhas cadastradas.
     *
     * @return void
     */

    public function testListAllAbelhaOK()
    {
        $this->get('/mostrarAbelhas')
            ->seeJsonEquals([
                "success" => true,
                "abelhas" => Abelha::all()
            ]);

        $this->assertEquals(200, $this->response->status());
    }

    /**
     * Teste que verifica o retorno de abelhas quando filtrada por nome ou especie.
     *
     * @return void
     */

    public function testGetByBuscaAbelhaOK()
    {

        $abelha = new Abelha();
        $this->json('GET', '/buscaAbelhas', ["busca" => "Uru"])
            ->seeJsonEquals([
                "success" => true,
                "abelhas" => $abelha->getByBusca('Uru')
            ]);
        $this->assertEquals(200, $this->response->status());
    }


    /**
     * Teste que verifica o retorno de abelhas quando falta busca.
     *
     * @return void
     */

    public function testGetByBuscaAbelhaMissingBusca()
    {

        $this->json('GET', '/buscaAbelhas', ["busca" => ""])
            ->seeJsonEquals([
                "busca" => ["O campo busca é obrigatório."]
            ]);
    }
}
