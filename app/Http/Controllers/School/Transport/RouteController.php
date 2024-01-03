<?php

namespace App\Http\Controllers\School\Transport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolRoute;
use App\Http\Resources\School\Transport\SchoolRoutesResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RouteController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $SchoolRoutes = SchoolRoute::where('school_id', $activeSchool->id)->active()->get();
        if (count($SchoolRoutes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'route_name' => SchoolRoutesResource::collection($SchoolRoutes),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'route_name' => null,
            'message' => 'No Route created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $SchoolRoutess = SchoolRoute::where('route_name', $request->route_name)->where('school_id', $activeSchool->id)->active()->first();

        if ($SchoolRoutess) return response([

            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Route is already exist'
        ]);

        $created = SchoolRoute::create([
            'school_id' => $activeSchool->id,
            'route_name' => $request->route_name,
        ]);

        if ($created) {
            $routename = SchoolRoute::find($created->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Route created successfully',
                'route_name' => new SchoolRoutesResource($routename),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create This Route',
        ]);
    }

    public function updateData(Request $request, SchoolRoute $schoolRoute)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $updated = $schoolRoute->update([
            'school_id' => $activeSchool->id,
            'route_name' => $request->route_name,
        ]);
        if ($updated) {

            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Route updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Route ',
        ]);
    }

    public function deleteData(Request $request, SchoolRoute $schoolRoute)
    {
        $updated = $schoolRoute->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'School Route data successfully ' . $request->status,
        ]);

        if ($request->status == 'activated') $message =
            'activate';
        else if ($request->status == 'deactivated') $message =
            'dectivate';
        else if ($request->status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
