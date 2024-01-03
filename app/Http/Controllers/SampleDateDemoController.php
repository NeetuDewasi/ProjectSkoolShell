<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleDateDemoController extends Controller
{
    public function sampleDataController()
    {
        $array = array(['a' => 10, 'b' => 20]);
        return response($array);
    }

    public function sampleDataDemoFunction2()
    {
        $array = array(['a' => 10, 'b' => 20]);
        return ['status' => "success", 'data' => $array];
    }
    public function sampleDataDemoFunction22(SchoolClass $id)
    {
        return response(['status' => "success", "message" => "SINGEL PARAMS", "param" => $id,]);
    }
    public function sampleDataDemoFunction23(SchoolClass $school_class, SchoolClass $sdfg)
    {
        return response(['status' => "success", 'school_class' => $school_class, 'id' => $sdfg,]);
    }
}
