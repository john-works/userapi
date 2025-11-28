<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfflineController extends Controller
{
    public function index(){
        return view('offline.index');
    }

    public function manifest(){
        header("Content-Type: text/cache-manifest");
        return 'CACHE MANIFEST
        # 2024-03-14 v3
        '.asset('js/jquery.js').'
        '.asset('offline/app.js').'
        
        NETWORK:
        *';
    }
}
