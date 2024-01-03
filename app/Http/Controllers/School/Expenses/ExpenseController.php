<?php

namespace App\Http\Controllers\School\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Expenses\ExpenseHeadDropDownResource;
use App\Http\Resources\School\Expenses\ExpenseResource;
use App\Models\Expense;
use App\Models\ExpenseHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $expenses= Expense::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($expenses) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'expenses' =>ExpenseResource::collection($expenses),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'expenses' => null,
            'message' => 'No Expense add yet..',
        ]);
    }
    public function getExpenseHeadData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $expenseHeads= ExpenseHead::where('school_id',$activeSchool->id)->allowed()->get();

        if($expenseHeads && count($expenseHeads) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'expense_head_list' => ExpenseHeadDropDownResource::collection($expenseHeads),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'expense_heads' => null,
            'message' => 'No Expense Head added yet..',
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
        $expense = Expense::where('name', $request->expense_name)->where('invoice_no',$request->expense_invoice_number)->where('school_id', $activeSchool->id)->allowed()->first();
        if($expense) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Expense already exits'
        ]);
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Expenses/images');
        }
        $created = Expense::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->expense_name,
            'expense_head_id' => $request->expense_head,
            'invoice_no' =>  $request->expense_invoice_number,
            'date' =>$request->expense_date,
            'amount' =>  $request->expense_amount,
            'documents' => $image,
            'description' => $request->expense_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Expenses Created Successfully',
                'expenses' => new ExpenseResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create expenses',
        ]);
    }

    public function getEditData(Expense $expense)
    {
        return response([
            'status' => 'success',
            'expenses' => new ExpenseResource($expense),
        ]);
    }

    public function updateData(Request $request , Expense $expense)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExist = Expense::where('name', $request->expense_name)->where('invoice_no',$request->expense_invoice_number)->where('school_id', $activeSchool->id)->where('id' , '!=' , $expense->id)->allowed()->first();
        if($alreadyExist) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Expense already exits'
        ]);
        $image = '';
        if ($expense->documents !== null &&  $expense->documents !== '' ) {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                Storage::delete($expense->documents);
                $image = '/storage/' . $request->image->store('Expenses/images');
            }else{
                $image = $expense->documents;
            }
        }else{
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Expenses/images');
            }else{
                $image = $expense->documents;
            }
        }
        $update = $expense->update([
            'name' =>  $request->expense_name,
            'expense_head_id' => $request->expense_head,
            'invoice_no' =>  $request->expense_invoice_number,
            'amount' =>  $request->expense_amount,
            'date' =>$request->expense_date,
            'documents' => $image,
            'description' => $request->expense_description,
        ]);

        if($update){
            $updateExpenses = Expense::find($expense->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Expenses Updated Successfully',
                'expenses' => new ExpenseResource($updateExpenses),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update expenses',
        ]);
    }

    public function changeStatusData(Request $request, Expense $expense)
    {
        $update = $expense->update(['status' => $request->expense_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Expense data successfully ' . $request->expense_status,
        ]);

        if ($request->expense_status == 'activated') $message =
            'activate';
        else if ($request->expense_status == 'deactivated') $message =
            'dectivate';
        else if ($request->expense_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

}
