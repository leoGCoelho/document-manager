<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentColController extends Controller
{
    public function make(Request $request, $document_id)
    {
        if($request->bearerToken() != env('APIKEY_EDITOR'))
            return response()->json('Unauthorized', 401);

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
        if($request->bearerToken() != env('APIKEY_EDITOR'))
            return response()->json('Unauthorized', 401);

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

    public function show(Request $request, $document_id)
    {
        if(($request->bearerToken() != env('APIKEY_VIEWER')) && ($request->bearerToken() != env('APIKEY_EDITOR')))
            return response()->json('Unauthorized', 401);
            
        $documentType = DocumentType::findOrFail($document_id);
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $res_data = [
            'name' => $documentType->name,
            'columns' => $documentType->cols()->get()->toArray(),
            'values' => $documentType->values()->get()->groupBy('uid')->toArray()
        ];

        return $this->apiresponse($res_data, 'data');
    }

    public function generatepdf(Request $request, $document_name){
        if(($request->bearerToken() != env('APIKEY_VIEWER')) && ($request->bearerToken() != env('APIKEY_EDITOR')))
            return response()->json('Unauthorized', 401);

        $documentType = DocumentType::where('name', $document_name)->first();
        if (!$documentType) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $res_data = [
            'name' => $documentType->name,
            'columns' => $documentType->cols()->get(),
            'values' => $documentType->values()->get()->groupBy('uid')
        ];
        
        $pdf = Pdf::loadView('defaultpdf', $res_data);

        $pdfName = str_replace(' ', '_', strtolower($document_name)) . '_' . strval(time()) . '.pdf';
        $pdfPath = 'public' . DIRECTORY_SEPARATOR . 'pdfs' . DIRECTORY_SEPARATOR . $pdfName;
        //dd(asset('storage/public' . DIRECTORY_SEPARATOR . $pdfPath));
        Storage::put($pdfPath, $pdf->output());

        return $this->apiresponse(asset('storage/pdfs/' . $pdfName), 'message');

    }

    public function update(Request $request, $document_id, $position)
    {
        if($request->bearerToken() != env('APIKEY_EDITOR'))
            return response()->json('Unauthorized', 401);

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
}
