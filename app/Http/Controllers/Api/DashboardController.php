<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Resource;

class DashboardController extends Controller
{
    public function widgets()
    {
        try {
            $data = [
                'resources' => Resource::count(),
            ];

            return $data;
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }
        return response()->json($response);
    }
}
