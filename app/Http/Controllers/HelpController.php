<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function menu_help() {
        $title='Help for Default Menu';
        return view('help.menu_help', compact('title'));
    }
    
     public function blocks_help() {
        $title='Help for Default Menu';
        return view('help.blocks_help', compact('title'));
    }
}
