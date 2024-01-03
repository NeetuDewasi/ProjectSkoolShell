<?php

namespace App\Http\Controllers\School\library;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Library\LibraryBookReckResource;
use App\Models\LibraryBookReck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReckController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $recks = LibraryBookReck::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($recks) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'recks' => LibraryBookReckResource::collection($recks),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'recks' => null,
            'message' => 'No Reck add yet..',
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
        $reck = LibraryBookReck::where('school_id',$activeSchool->id)->where('reck_name', $request->reck_name)->allowed()->first();

        if($reck) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $created = LibraryBookReck::create([
            'school_id' => $activeSchool->id,
            'reck_name' => $request->reck_name,
            'shelf_count' => $request->shelf_count,
        ]);

        if($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'reck' => new LibraryBookReckResource($created),
            'message' => 'Reck created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);

    }
    public function updateData(Request $request, LibraryBookReck $libraryBookReck)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $reck = LibraryBookReck::where('school_id',$activeSchool->id)->where('id', '!=', $libraryBookReck->id)->where('reck_name', $request->reck_name)->allowed()->first();
        if($reck) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $updated = $libraryBookReck->update([
            'reck_name' => $request->reck_name,
            'shelf_count' => $request->shelf_count,
        ]);

        if($updated) {
            $reck = LibraryBookReck::where('id', $libraryBookReck->id)->allowed()->first();
            return response([
                'status' => 'success',
                'status_code' => 201,
                'reck' => new LibraryBookReckResource($reck),
                'message' => 'Reck created successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);

    }
}
