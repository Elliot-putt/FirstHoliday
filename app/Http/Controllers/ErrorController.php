<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorController extends Controller {

    /////////////////////////////////////////////
    ///////////////////Error return//////////////
    /////////////////////////////////////////////
    public static function forbidden(string $link = '/', string $message = 'Unauthorised for this action' , int $status = 403)
    {
        return Inertia::render('Auth/403', [
            'link' => $link,
            'message' => $message,
            'status' => $status,
        ])->toResponse(\request())->setStatusCode(403);
    }

}
