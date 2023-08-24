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
            'GET :: /documenttypes' => 'Retorna a lista de tipos de documentos',
            'POST :: /documenttypes/add' => 'Adiciona um novo tipo de documento',
            'PUT :: /documenttypes/edit/{id}' => 'Edita um tipo de documento',
            'DELETE :: /documenttypes/delete/{id}' => 'Deleta um tipo de documento',
            'GET :: /documentcols/{id_do_tipodedocumento}' => 'Retorna a lista de colunas de um tipo de documento',
            'POST :: /documentcols/make/{id_do_tipodedocumento}' => 'Cria as colunas de um tipo de documento',
            'POST :: /documentcols/add/{id_do_tipodedocumento}' => 'Adiciona uma nova coluna a um tipo de documento',
            'PUT :: /documentcols/edit/{id_do_tipodedocumento}/{position}' => 'Edita uma coluna de um tipo de documento',
            'POST :: /documentvalues/add/{id_do_tipodedocumento}' => 'Adiciona os valores de um documento',
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
