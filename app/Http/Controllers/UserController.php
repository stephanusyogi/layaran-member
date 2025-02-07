<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account_details($user_id){
        dd($user_id);
    }
}
