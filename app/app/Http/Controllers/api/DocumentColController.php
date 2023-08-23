<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentColController extends Controller
{
    public function make(Request $request, $document_id)
    {
        $request_data = $request->all();

        if (!isset($request_data['columns'])) {
            return $this->apiresponse("O campo 'columns' é obrigatório", 'error', 400);
        }

        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $documentType->cols()->delete();
        foreach ($request_data['columns'] as $key => $column) {
            if(!isset($column['name']) || ( isset($column['name']) && ($column['name'] == '' || is_null($column['name'])) ) ) {
                return $this->apiresponse("O campo 'name' é obrigatório no elemento " . strval($key+1), 'error', 400);
            }

            $column['position'] = $key + 1;
            $documentType->cols()->create($column);
        }

        return $this->apiresponse($documentType->cols()->get()->toArray(), 'data');
    }

    public function enqueue(Request $request, $document_id)
    {
        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $request_data = $request->all();

        if (!isset($request_data['name']) || (isset($request_data['name']) && ($request_data['name'] == '' || is_null($request_data['name'])))) {
            return $this->apiresponse("O campo 'name' é obrigatório", 'error', 400);
        }

        if (!isset($request_data['typecol']) || (isset($request_data['typecol']) && ($request_data['typecol'] == '' || is_null($request_data['typecol'])))) {
            return $this->apiresponse("O campo 'typecol' é obrigatório", 'error', 400);
        }

        $request_data['position'] = $documentType->cols()->count() + 1;

        $documentCol = $documentType->cols()->create($request_data);

        return $this->apiresponse($documentCol, 'data');
    }

    public function show($document_id)
    {
        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        return $this->apiresponse($documentType->cols()->get()->toArray(), 'data');
    }

    public function update(Request $request, $document_id, $position)
    {
        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $documentCol = $documentType->cols()->where('position', $position)->first();
        if (!$documentCol) {
            return $this->apiresponse("Coluna não encontrada", 'error', 404);
        }

        $request_data = $request->all();

        $documentCol->update($request_data);

        return $this->apiresponse($documentCol, 'data');
    }

    public function destroy($id)
    {
        //
    }
}
