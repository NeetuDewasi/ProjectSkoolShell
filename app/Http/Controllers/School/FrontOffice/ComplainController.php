<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\ComplainResource;
use App\Http\Resources\School\Front_Office\ComplainTypeDropDownResource;
use App\Http\Resources\School\Front_Office\ComplainTypeResource;
use App\Http\Resources\School\Front_Office\SourceDropDownResource;
use App\Models\Complain;
use App\Models\ComplainType;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ComplainController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $complains= Complain::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($complains) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'complains' =>ComplainResource::collection($complains),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'complains' => null,
            'message' => 'No Complains add yet..',
        ]);
    }
    public function getComplainTypeData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $complainType= ComplainType::where('school_id',$activeSchool->id)->allowed()->get();

        if($complainType && count($complainType) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'complain_type_list' => ComplainTypeDropDownResource::collection($complainType),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'complain_type_list' => null,
            'message' => 'No Complain Type added yet..',
        ]);
    }
    public function getSourceData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $source= Source::where('school_id',$activeSchool->id)->allowed()->get();

        if($source && count($source) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'source_list' => SourceDropDownResource::collection($source),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'source_list' => null,
            'message' => 'No Source added yet..',
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
        $complain = Complain::where('phone', $request->complain_phone)->where('school_id', $activeSchool->id)->allowed()->first();
        if($complain) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complains  already exits'
        ]);

        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Complains/images');
        }
        $created = Complain::create([
            'school_id'=> $activeSchool->id,
            'complain_type_id' =>  $request->complain_type_id,
            'source_id' => $request->complain_source_id,
            'complain_by' => $request->complain_person,
            'phone' => $request->complain_phone,
            'date' => date_format(date_create($request->complain_date), 'Y-m-d'),
            'action_by' =>  $request->complain_action_by,
            'assigned' => $request->complain_assigned,
            'document' => $image,
            'description' => $request->complain_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Complain Created Successfully',
                'complain' => new ComplainResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees',
        ]);
    }

    public function getEditData(Complain $complain)
    {
        return response([
            'status' => 'success',
            'complain' => new ComplainResource($complain),
        ]);
    }

    public function updateData(Request $request , Complain $complain)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Complain::where('phone', $request->complain_phone)->where('school_id', $activeSchool->id)->where('id', '!=', $complain->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complains  already exits'
        ]);
        $image = '';
        if ($complain->document !== null &&  $complain->document !== '' ) {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                Storage::delete($complain->document);
                $image = '/storage/' . $request->image->store('Complains/images');
            }else{
                $image = $complain->document;
            }
        }else{
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Complains/images');
            }else{
                $image = $complain->document;
            }
        }
        $update = $complain->update([
            'complain_type_id' =>  $request->complain_type_id,
            'source_id' => $request->complain_source_id,
            'complain_by' => $request->complain_person,
            'phone' => $request->complain_phone,
            'date' => date_format(date_create($request->complain_date), 'Y-m-d'),
            'action_by' =>  $request->complain_action_by,
            'assigned' => $request->complain_assigned,
            'document' => $image,
            'description' => $request->complain_description,
        ]);

        if($update){
            $updateComplain = Complain::find($complain->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Complains Updated Successfully',
                'complain' => new ComplainResource($updateComplain),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Complains',
        ]);
    }

    public function changeStatusData(Request $request, Complain $complain)
    {
        $update = $complain->update(['status' => $request->complain_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Master data successfully ' . $request->complain_status,
        ]);

        if ($request->complain_status == 'activated') $message =
            'activate';
        else if ($request->complain_status == 'deactivated') $message =
            'dectivate';
        else if ($request->complain_status == 'deleted') $message = 'delete';
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

    public function getComplainData(Complain $complain)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $complain = Complain::where('id', $complain->id)->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'complain' =>new ComplainResource($complain),
            'message' => '',
        ]);
    }
}
