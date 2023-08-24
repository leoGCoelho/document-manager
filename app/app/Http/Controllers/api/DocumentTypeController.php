<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return $this->apiresponse(DocumentType::all()->toArray(), 'data');
    }

    public function store(Request $request)
    {
        $request_data = $request->all();

        if(!isset($request_data['name']) || ( isset($request_data['name']) && ($request_data['name'] == '' || is_null($request_data['name'])) ) ) {
            return $this->apiresponse("O campo 'name' é obrigatório", 'error', 400);
        }
        
        $documenttype = DocumentType::create($request_data);

        return $this->apiresponse($documenttype, 'data');
    }

    public function update(Request $request, $id)
    {
        $documenttype = DocumentType::find($id);

        if(!$documenttype) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }
        
        $request_data = $request->all();

        $documenttype->update($request_data);

        return $this->apiresponse($documenttype, 'data');
        
    }

    public function destroy($id)
    {
        $documenttype = DocumentType::find($id);

        if(!$documenttype) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $documenttype->delete();

        return $this->apiresponse("Tipo de documento deletado com sucesso", 'message');
    }
}
