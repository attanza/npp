<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dream;

class BmiController extends Controller
{
    public function index()
    {
        return view('bmi.index');
    }


}
