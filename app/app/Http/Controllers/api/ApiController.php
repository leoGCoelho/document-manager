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
    public function index()
    {
        $endpoints = [
            'GET :: /' => 'Retorna a lista de endpoints',
            'GET :: /ping' => "Verifica se o servidor está ativo, retornando a string 'pong'",
            'GET :: /documenttypes' => 'Retorna a lista de tipos de documentos',
        ];

        return $this->apiresponse($endpoints, 'data');
    }

    public function ping()
    {
        return response()->json('pong', 200);
    }
}
