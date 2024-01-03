<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\PostalResource;
use App\Models\Postal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostalController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $postals= Postal::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($postals) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'postals' =>PostalResource::collection($postals),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'postals' => null,
            'message' => 'No Postals add yet..',
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
        $postal = Postal::where('ref_no', $request->postal_ref_no)->where('school_id', $activeSchool->id)->allowed()->first();
        if($postal) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complains  already exits'
        ]);
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Postal/images');
        }
        $created = Postal::create([
            'school_id'=> $activeSchool->id,
            'from_title' =>  $request->postal_from_title,
            'to_title' => $request->postal_to_title,
            'ref_no' => $request->postal_ref_no,
            'postal_type' => $request->postal_type,
            'date' => date_format(date_create($request->postal_date), 'Y-m-d'),
            'document' =>  $image,
            'address' => $request->postal_address,
            'note' => $request->postal_note,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Postal Created Successfully',
                'postal' => new PostalResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Postal',
        ]);
    }

    public function getEditData(Postal $postal)
    {
        return response([
            'status' => 'success',
            'postal' => new PostalResource($postal),
        ]);
    }

    public function updateData(Request $request , Postal $postal)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Postal::where('ref_no', $request->postal_ref_no)->where('school_id', $activeSchool->id)->where('id','!=',$postal->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complains  already exits'
        ]);
        $image = '';
        if ($postal->document !== null &&  $postal->document !== '' ) {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                Storage::delete($postal->document);
                $image = '/storage/' . $request->image->store('Postals/images');
            }else{
                $image = $postal->document;
            }
        }else{
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Postals/images');
            }else{
                $image = $postal->document;
            }
        }
        $update = $postal->update([
            'from_title' =>  $request->postal_from_title,
            'to_title' => $request->postal_to_title,
            'ref_no' => $request->postal_ref_no,
            'postal_type' => $request->postal_type,
            'date' => date_format(date_create($request->postal_date), 'Y-m-d'),
            'document' =>  $image,
            'address' => $request->postal_address,
            'note' => $request->postal_note,
        ]);

        if($update){
            $updatePostal = Postal::find($postal->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Postal Updated Successfully',
                'postal' => new PostalResource($updatePostal),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Postal',
        ]);
    }

    public function changeStatusData(Request $request, Postal $postal)
    {
        $update = $postal->update(['status' => $request->postal_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Master data successfully ' . $request->postal_status,
        ]);

        if ($request->postal_status == 'activated') $message =
            'activate';
        else if ($request->postal_status == 'deactivated') $message =
            'dectivate';
        else if ($request->postal_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
    public function getPostalData(Postal $postal)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $postal = Postal::where('id', $postal->id)->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'postal' =>new PostalResource($postal),
            'message' => '',
        ]);
    }
}
