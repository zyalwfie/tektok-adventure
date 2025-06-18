<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure'
        ];
        
        return view('landing/index', $data);
    }

    public function cart()
    {
        $data = [
            'pageTitle' => 'Tektok Adventure | Keranjang'
        ];
        
        return view('landing/cart/index', $data);
    }
}
