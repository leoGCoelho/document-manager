<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentValueController extends Controller
{
    public function store(Request $request, $document_id)
    {
        if($request->bearerToken() != env('APIKEY_EDITOR'))
            return response()->json('Unauthorized', 401);

        $request_data = $request->all();

        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $uid = Str::uuid();
        $columns = $documentType->cols()->get()->toArray();
        $i=0;
        foreach ($request_data as $key => $value) {
            $column = array_filter($columns, function ($col) use ($key) {
                return $col['name'] == $key;
            });

            if (count($column) == 0) {
                return $this->apiresponse("Coluna '" . $key . "' não encontrada", 'error', 404);
            }

            $value_data = ['uid' => $uid, 'value' => $value];
            //dd($column[$i]['id']);

            $documentType->cols()->find($column[$i]['id'])->values()->create($value_data);
            $i++;
        }

        return $this->apiresponse('Respostas enviadas com sucesso!', 'message');
    }
}
