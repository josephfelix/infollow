<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class IHomeController
 */
class HomeController extends Controller
{
    /**
     * Exibe a página inicial após o login do usuário no sistema
     */
    public function index(Request $request)
    {
        $user = $request->session()->get('user');

        return view('painel.home', ['user' => $user]);
    }
}
