<?php

namespace App\Http\Controllers\School\Income;

use App\Http\Controllers\Controller;
use App\Models\IncomeHead;
use Illuminate\Http\Request;
use App\Http\Resources\School\Income\IncomeHeadResource;

class IncomeHeadController extends Controller
{
    public function getData()
    {
        $IncomeHeads = IncomeHead::where('school_id', 1)->get();
        if(count($IncomeHeads) > 0) return response([
                'status' => 'success',
                'status_code' => 200,
                'income_heads' =>IncomeHeadResource::collection($IncomeHeads),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'income_heads' => null,
            'message' => 'No income head created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $incomeHeads = IncomeHead::where('income_head', $request->income_head)->where('school_id', 1)->first();

        if($incomeHeads) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This income head is already exist'
        ]);

        $created = IncomeHead::create([
            'school_id' => 1,
            'income_head' => $request->income_head,
            'description' => $request->description
        ]);

        if($created) {
            $incomeHeads=IncomeHead::find($created->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'income head created successfully',
                'income_heads' => new IncomeHeadResource($incomeHeads),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }

    public function getEditData(IncomeHead $IncomeHead)
    {

        return response([
            'status' => 'success',
            'income_heads' => new IncomeHeadResource($IncomeHead),
        ]);
    }

    public function updateData(Request $request, IncomeHead $IncomeHead)
    {
        $updated = $IncomeHead->update([
            'school_id' => 1,
            'income_head' => $request->income_head,
            'description' => $request->description
        ]);

        if($updated) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'income head updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }

    public function deleteData(IncomeHead $IncomeHead)
    {
        $deleted = $IncomeHead->delete();
        if($deleted) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'income head deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);

    }
}
