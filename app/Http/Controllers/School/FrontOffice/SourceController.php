<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\SourceResource;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SourceController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $sources = Source::where('school_id',$activeSchool->id)->allowed()->get(); // isme value nhi h
        if(count($sources) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'sources' =>SourceResource::collection($sources),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'sources' => null,
            'message' => 'No Source Created Yet',
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
        $source = Source::where('name', $request->source_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($source) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Source already exits'
        ]);

        $created = Source::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->source_name,
            'description' => $request->source_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Source Created Successfully',
                'source' => new SourceResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Source',
        ]);
    }
    public function getEditData(Source $source)
    {
        return response([
            'status' => 'success',
            'source' => new SourceResource($source),
        ]);
    }

    public function updateData(Request $request , Source $source)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Source::where('name', $request->source_name)->where('school_id', $activeSchool->id)->where('id', '!=', $source->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Source already exits'
        ]);
        $update = $source->update([
            'name' =>  $request->source_name,
            'description' => $request->source_description,

        ]);
        if($update){
            $updateSource = Source::find($source->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Source Updated Successfully',
                'source' => new SourceResource($updateSource),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Source',
        ]);
    }

    public function changeStatusData(Request $request, Source $source)
    {
        $update = $source->update(['status' => $request->source_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Source data successfully ' . $request->source_status,
        ]);

        if ($request->source_status == 'activated') $message =
            'activate';
        else if ($request->source_status == 'deactivated') $message =
            'dectivate';
        else if ($request->source_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
