<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiresponse ($data = null, $typeresponse = null, $status = 200) {
        $success = $typeresponse!='error'?true:false;

        $res = [
            'success' => $success
        ];

        if ($typeresponse == 'message') $res['message'] = $data;
        if ($typeresponse == 'error') $res['error'] = $data;
        if ($typeresponse == 'data') $res['data'] = $data;

        return response()->json($res, $status);
    }
}
