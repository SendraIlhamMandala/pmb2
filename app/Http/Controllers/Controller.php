<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #function gethtmlpage
    public function gethtmlpage(): HttpResponse
    {
        $html = "<html> <center> <h1>All html document conddtent </h1> </center></html>";

        return response($html, 200)->header('Content-Type', 'text/html');
    }


}
