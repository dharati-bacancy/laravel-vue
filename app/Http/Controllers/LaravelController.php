<?php

namespace App\Http\Controllers;

use App\Resource;
use Str;

class LaravelController extends Controller
{
    public function index()
    {
        return view('layout');
    }
}
