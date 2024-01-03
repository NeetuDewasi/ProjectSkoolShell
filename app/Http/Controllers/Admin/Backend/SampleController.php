<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function getData()
    {
        return response([
            'status' => 'success',
            'message' => 'ok',
            "number1" => 50,
            "number2" => 60,
        ]);
    }
}
