<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\ReferenceResouce;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReferenceController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $references = Reference::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($references) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'references' =>ReferenceResouce::collection($references),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'references' => null,
            'message' => 'No Reference Created Yet',
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
        $reference = Reference::where('name', $request->reference_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($reference) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Reference already exits'
        ]);

        $created = Reference::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->reference_name,
            'description' => $request->reference_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Reference Created Successfully',
                'reference' =>new ReferenceResouce($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Reference',
        ]);
    }
    public function getEditData(Reference $reference)
    {
        return response([
            'status' => 'success',
            'reference' => new ReferenceResouce($reference),
        ]);
    }
    public function updateData(Request $request , Reference $reference)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Reference::where('name', $request->reference_name)->where('school_id', $activeSchool->id)->where('id', '!=', $reference->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Reference already exits'
        ]);
        $update = $reference->update([
            'name' =>  $request->reference_name,
            'description' => $request->reference_description,

        ]);
        if($update){
            $updateReference = Reference::find($reference->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Reference Updated Successfully',
                'reference' => new ReferenceResouce($updateReference),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Reference',
        ]);
    }
    public function changeStatusData(Request $request, Reference $reference)
    {
        $update = $reference->update(['status' => $request->reference_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'reference data successfully ' . $request->reference_status,
        ]);
        if ($request->reference_status == 'activated') $message =
            'activate';
        else if ($request->reference_status == 'deactivated') $message =
            'dectivate';
        else if ($request->reference_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

}
