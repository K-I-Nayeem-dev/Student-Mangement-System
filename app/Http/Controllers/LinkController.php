<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(){
        return view('layouts.dashboard.links.index');
    }
}