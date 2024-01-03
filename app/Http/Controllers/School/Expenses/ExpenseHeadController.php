<?php

namespace App\Http\Controllers\School\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Expenses\ExpenseHeadResource;
use App\Models\ExpenseHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExpenseHeadController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $expenseHeads = ExpenseHead::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($expenseHeads) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'expense_heads' =>ExpenseHeadResource::collection($expenseHeads),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'expense_heads' => null,
            'message' => 'No Expense Heads Created Yet',
        ]);
    }

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $expenseHead = ExpenseHead::where('name', $request->expense_head_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($expenseHead) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Expense Head already exits'
        ]);

        $created = ExpenseHead::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->expense_head_name,
            'description' => $request->expense_head_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Expenses Head Created Successfully',
                'expense_head' =>new ExpenseHeadResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create expense head',
        ]);
    }

    public function getEditData(ExpenseHead $expenseHead)
    {
        return response([
            'status' => 'success',
            'expenses_head' => new ExpenseHeadResource($expenseHead),
        ]);
    }

    public function updateData(Request $request , ExpenseHead $expenseHead)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExist = ExpenseHead::where('name', $request->expense_head_name)->where('school_id', $activeSchool->id)->where('id', '!=', $expenseHead->id)->allowed()->first();

        if($alreadyExist) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Expense Head already exits'
        ]);
        $update = $expenseHead->update([
            'name' =>  $request->expense_head_name,
            'description' => $request->expense_head_description,
        ]);

        if($update){
            $updateExpenseHead = ExpenseHead::find($expenseHead->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Expenses Head Updated Successfully',
                'expense_head' => new ExpenseHeadResource($updateExpenseHead),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update expense head',
        ]);
    }

    public function changeStatusData(Request $request, ExpenseHead $expenseHead)
    {
        $update = $expenseHead->update(['status' => $request->expense_head_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Expense Head data successfully ' . $request->expense_head_status,
        ]);

        if ($request->expense_head_status == 'activated') $message =
            'activate';
        else if ($request->expense_head_status == 'deactivated') $message =
            'dectivate';
        else if ($request->expense_head_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
