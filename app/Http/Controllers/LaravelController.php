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
    public function insertResources()
    {
        try {
            $rows = 100;
            $from = 1;
            for ($i=1; $i <= 100 ; $i++) { 
                Resource::create([
                    'name' => Str::random(5),
                    'image' => 'resources/default.jpeg'
                ]);
            }
            $response = "Insert Successfully";
        } catch(\Exception $e) {
            $response = $e->getMessage() .' '. $e->getFile() .' '. $e->getLine();
        }
        print_r($response);
    }
}
