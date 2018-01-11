<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class LogoutController
 */
class LogoutController extends Controller
{
    /**
     * Realiza o logout na plataforma
     */
    public function index(Request $request)
    {
        $request->session()->forget(['loggedin', 'user']);
        $request->session()->flush();
        return redirect('/');
    }
}
