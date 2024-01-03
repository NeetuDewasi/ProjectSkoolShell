<?php

namespace App\Http\Controllers\School\Hostel;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Hostel\HostelResource;
use App\Models\Hostel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HostelController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $hostels= Hostel::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($hostels) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'hostels' =>HostelResource::collection($hostels),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostels' => null,
            'message' => 'No Hostels add yet..',
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
        $hostel = Hostel::where('hostel_name', $request->hostel_name)->where('email', $request->hostel_email)->where('school_id', $activeSchool->id)->allowed()->first();
        if($hostel) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Enuieries already exits'
        ]);
        $created = Hostel::create([
            'school_id'=> $activeSchool->id,
            'hostel_name' => $request->hostel_name,
            'type' => $request->hostel_type,
            'intake' => $request->hostel_intake,
            'contact_person' => $request->hostel_person,
            'contact_number' => $request->hostel_number,
            'alternative_contact_number' => $request->hostel_alt_number,
            'email' => $request->hostel_email,
            'address_line1' => $request->hostel_address_line1,
            'hostel_address_line2' => $request->hostel_address_line2,
            'area' => $request->hostel_area,
            'landmark' => $request->hostel_landmark,
            'city' => $request->hostel_city,
            'state' => $request->hostel_state,
            'country' => $request->hostel_country,
            'pincode' => $request->hostel_pincode,
            'description' => $request->hostel_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel Created Successfully',
                'hostel' => new HostelResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Hostel',
        ]);
    }

    public function getEditData(Hostel $hostel)
    {
        return response([
            'status' => 'success',
            'hostel' => new HostelResource($hostel),
        ]);
    }

    public function updateData(Request $request , Hostel $hostel)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Hostel::where('hostel_name', $request->hostel_name)->where('email', $request->hostel_email)->where('school_id', $activeSchool->id)->where('id','!=',$hostel->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Enuieries already exits'
        ]);
        $update = $hostel->update([
            'hostel_name' => $request->hostel_name,
            'type' => $request->hostel_type,
            'intake' => $request->hostel_intake,
            'contact_person' => $request->hostel_person,
            'contact_number' => $request->hostel_number,
            'alternative_contact_number' => $request->hostel_alt_number,
            'email' => $request->hostel_email,
            'address_line1' => $request->hostel_address_line1,
            'hostel_address_line2' => $request->hostel_address_line2,
            'area' => $request->hostel_area,
            'landmark' => $request->hostel_landmark,
            'city' => $request->hostel_city,
            'state' => $request->hostel_state,
            'country' => $request->hostel_country,
            'pincode' => $request->hostel_pincode,
            'description' => $request->hostel_description,
        ]);

        if($update){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Hostel',
        ]);
    }

    public function changeStatusData(Request $request, Hostel $hostel)
    {
        $update = $hostel->update(['status' => $request->hostel_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Enquiries data successfully ' . $request->hostel_status,
        ]);

        if ($request->hostel_status == 'activated') $message =
            'activate';
        else if ($request->hostel_status == 'deactivated') $message =
            'dectivate';
        else if ($request->hostel_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
