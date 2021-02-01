<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


/* ROTAS RESPONSAVEIS PARA GERENCIAR ABELHAS */
$router->get('/mostrarAbelhas','AbelhaController@listAll');
$router->get('/buscaAbelhas','AbelhaController@getByBusca');
$router->post('/cadastrarAbelha','AbelhaController@store');


/* ROTAS RESPONSAVEIS PARA GERENCIAR FLORES */
$router->post('/cadastrarFlor','FlorController@store');
$router->get('/buscaFlores','FlorController@getByFilter');
$router->get('/buscaFlor','FlorController@getById');