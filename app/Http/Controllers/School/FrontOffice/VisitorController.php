<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\PurposeDropDownResource;
use App\Http\Resources\School\Front_Office\VisitorResource;
use App\Models\Purpose;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class VisitorController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $visitors= Visitor::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($visitors) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'visitors' =>VisitorResource::collection($visitors),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'visitors' => null,
            'message' => 'No Visitors add yet..',
        ]);
    }
    public function getPurposeData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $purpose= Purpose::where('school_id',$activeSchool->id)->allowed()->get();

        if($purpose && count($purpose) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'purpose_list' => PurposeDropDownResource::collection($purpose),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'purpose_list' => null,
            'message' => 'No Purpose added yet..',
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
        $visitor = Visitor::where('id_card', $request->visitor_id_card)->where('school_id', $activeSchool->id)->allowed()->first();
        if($visitor) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This visitors already exits'
        ]);
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Visitor/images');
        }
        $created = Visitor::create([
            'school_id'=> $activeSchool->id,
            'purpose_id' =>  $request->visitor_purpose_id,
            'name' => $request->visitor_name,
            'phone' => $request->visitor_phone,
            'email' => $request->visitor_email,
            'id_card' => $request->visitor_id_card,
            'no_of_person' => $request->visitor_no_of_person,
            'date' => $request->visitor_date,
            'in_time' => $request->visitor_in_time,
            'out_time' => $request->visitor_out_time,
            'document' =>  $image,
            'note' => $request->visitor_note,

        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Visitor Created Successfully',
                'visitor' => new VisitorResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create visitors',
        ]);
    }

    public function getEditData(Visitor $visitor)
    {
        return response([
            'status' => 'success',
            'visitor' => new VisitorResource($visitor),
        ]);
    }

    public function updateData(Request $request , Visitor $visitor)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Visitor::where('id_card', $request->visitor_id_card)->where('school_id', $activeSchool->id)->where('id', '!=', $visitor->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This visitors already exits'
        ]);
        $image = '';
        if ($visitor->document !== null &&  $visitor->document !== '' ) {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                Storage::delete($visitor->document);
                $image = '/storage/' . $request->image->store('Visitor/images');
            }else{
                $image = $visitor->document;
            }
        }else{

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Visitor/images');
            }else{
                $image = $visitor->document;
            }
        }
        $update = $visitor->update([
            'purpose_id' =>  $request->visitor_purpose_id,
            'name' => $request->visitor_name,
            'phone' => $request->visitor_phone,
            'email' => $request->visitor_email,
            'id_card' => $request->visitor_id_card,
            'no_of_person' => $request->visitor_no_of_person,
            'date' => $request->visitor_date,
            'in_time' => $request->visitor_in_time,
            'out_time' => $request->visitor_out_time,
            'document' =>  $image,
            'note' => $request->visitor_note,
        ]);

        if($update){
            $updateVisitor = Visitor::find($visitor->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Visitors Updated Successfully',
                'visitor' => new VisitorResource($updateVisitor),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Visitors',
        ]);
    }

    public function changeStatusData(Request $request, Visitor $visitor)
    {
        $update = $visitor->update(['status' => $request->visitor_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Master data successfully ' . $request->visitor_status,
        ]);

        if ($request->visitor_status == 'activated') $message =
            'activate';
        else if ($request->visitor_status == 'deactivated') $message =
            'dectivate';
        else if ($request->visitor_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
    public function getVisitorData(Visitor $visitor)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $visitor = Visitor::where('id', $visitor->id)->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'visitor' =>new VisitorResource($visitor),
            'message' => '',
        ]);
    }
}
