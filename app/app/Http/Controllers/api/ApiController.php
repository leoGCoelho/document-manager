<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(($request->bearerToken() != env('APIKEY_VIEWER')) && ($request->bearerToken() != env('APIKEY_EDITOR')))
            return response()->json('Unauthorized', 401);

        $endpoints = [
            'GET :: /' => 'Retorna a lista de endpoints',
            'GET :: /ping' => "Verifica se o servidor está ativo, retornando a string 'pong'",
            'GET :: /document/types' => 'Retorna a lista de tipos de documentos',
            'POST :: /document/types/add' => 'Adiciona um novo tipo de documento',
            'PUT :: /document/types/edit/{id}' => 'Edita um tipo de documento',
            'DELETE :: /document/types/delete/{id}' => 'Deleta um tipo de documento',
            'GET :: /document/cols/{id_do_tipodedocumento}' => 'Retorna a lista de colunas de um tipo de documento',
            'POST :: /document/cols/make/{id_do_tipodedocumento}' => 'Cria as colunas de um tipo de documento',
            'POST :: /document/cols/add/{id_do_tipodedocumento}' => 'Adiciona uma nova coluna a um tipo de documento',
            'PUT :: /document/cols/edit/{id_do_tipodedocumento}/{position}' => 'Edita uma coluna de um tipo de documento',
            'POST :: /document/values/add/{id_do_tipodedocumento}' => 'Adiciona os valores de um documento',
            'GET :: /document/pdf/{nome_do_tipodedocumento}' => 'Gera um PDF de um documento'
        ];

        return $this->apiresponse($endpoints, 'data');
    }

    public function ping(Request $request)
    {
        if(($request->bearerToken() != env('APIKEY_VIEWER')) && ($request->bearerToken() != env('APIKEY_EDITOR')))
            return response()->json('Unauthorized', 401);
        
        return response()->json('pong', 200);
    }
}
