<?php

namespace App\Http\Controllers\School\Income;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function getData()
    {
        $Incomes = Income::where('school_id', 1)->get();
        if(count($Incomes) > 0) return response([
                'status' => 'success',
                'status_code' => 200,
                'incomes' => $Incomes,
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'incomes' => null,
            'message' => 'No Disabled Staff created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $Incomes = Income::where('disabled_staff_name', $request->disabled_staff_name)->where('school_id', 1)->first();

        if($Incomes) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This income head is already exist'
        ]);

        $created = Income::create([
            'school_id' => 1,
            'disabled_staff_name' => $request->disabled_staff_name,
            'description' => $request->description,
        ]);

        if($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Disabled Staff  created successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Disabled Staff ',
        ]);
    }

    public function getEditData(Income $Income)
    {
        return response([
            'status' => 'success',
            'Income' => $Income,
        ]);
    }

    public function updateData(Request $request, Income $Income)
    {
        $updated = $Income->update([
            'school_id' => 1,
            'disabled_staff_name'=> $request->disabled_staff_name,
            'description'=> $request->description,
        ]);
        if($updated) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'income  Dissabled Staff updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }

    public function deleteData(Income $Income)
    {
        $deleted = $Income->delete();
        if($deleted) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'income Dissabled Staff deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);

    }
}
