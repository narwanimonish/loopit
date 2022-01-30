<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function whoAmI(Request $request)
    {
        return $this->success(null, $request->user());
    }
}
