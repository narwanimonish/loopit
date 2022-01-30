<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function listAvailableCars(Request $request)
    {
        $availableCars = Car::inStock()->get();

        return $this->success('List of Cars', $availableCars);
    }
}
