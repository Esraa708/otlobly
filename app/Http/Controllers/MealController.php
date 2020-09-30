<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(){
        $meals=Meal::all();
        return response(['meals' => $meals]);
    }
}
