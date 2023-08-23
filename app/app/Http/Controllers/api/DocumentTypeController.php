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

        if(isset($request_data['pdftemplate']) && ($request_data['pdftemplate']!=null)) {
            if( !isset($request_data['pdftemplate']['name']) || !isset($request_data['pdftemplate']['base64']) ) {
                return $this->apiresponse("Os campo de 'name' e 'base64' são obrigatórios", 'error', 400);
            }
            $filename_r = explode('.', $request_data['pdftemplate']['name']);
            $filename = $filename_r[0];
            array_shift($filename_r);
            $filename = $filename . strval(time()) . '.' . implode('.', $filename_r);

            $file_data = base64_decode($request_data['pdftemplate']['base64']);
            Storage::put('public' . DIRECTORY_SEPARATOR . 'pdftemplates' . DIRECTORY_SEPARATOR . $filename, $file_data);

            unset($request_data['pdftemplate']);
            $request_data['pdftemplate'] = $filename;
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

        if(isset($request_data['pdftemplate']) && ($request_data['pdftemplate']!=null)) {
            if( !isset($request_data['pdftemplate']['name']) || !isset($request_data['pdftemplate']['base64']) ) {
                return $this->apiresponse("Os campo de 'name' e 'base64' são obrigatórios", 'error', 400);
            }
            
            $deleted = Storage::delete('public' . DIRECTORY_SEPARATOR . 'pdftemplates' . DIRECTORY_SEPARATOR . $documenttype->pdftemplate);
            if(!$deleted) {
                return $this->apiresponse("Erro ao deletar o arquivo de template", 'error', 500);
            }

            $filename_r = explode('.', $request_data['pdftemplate']['name']);
            $filename = $filename_r[0];
            array_shift($filename_r);
            $filename = $filename . strval(time()) . '.' . implode('.', $filename_r);

            $file_data = base64_decode($request_data['pdftemplate']['base64']);
            Storage::put('public' . DIRECTORY_SEPARATOR . 'pdftemplates' . DIRECTORY_SEPARATOR . $filename, $file_data);

            unset($request_data['pdftemplate']);
            $request_data['pdftemplate'] = $filename;
        }

        $documenttype->update($request_data);

        return $this->apiresponse($documenttype, 'data');
        
    }

    public function destroy($id)
    {
        $documenttype = DocumentType::find($id);

        if(!$documenttype) {
            return $this->apiresponse("Tipo de documento não encontrado", 'error', 404);
        }

        $deleted = Storage::delete('public' . DIRECTORY_SEPARATOR . 'pdftemplates' . DIRECTORY_SEPARATOR . $documenttype->pdftemplate);
        if(!$deleted) {
            return $this->apiresponse("Erro ao deletar o arquivo de template", 'error', 500);
        }

        $documenttype->delete();

        return $this->apiresponse("Tipo de documento deletado com sucesso", 'message');
    }
}
