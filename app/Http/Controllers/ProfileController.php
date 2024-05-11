<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('layouts.dashboard.profile.index');
    }
    
    public function user_profile($id){
        
        $user = User::find($id);
        
        return view('layouts.dashboard.profile.show', 
            [
                'user' => $user,
            ]
        );
        
    }
    
}