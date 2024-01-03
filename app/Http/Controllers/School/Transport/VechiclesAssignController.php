<?php

namespace App\Http\Controllers\School\Transport;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Transport\AssignRouteResource;
use App\Http\Resources\School\Transport\AssignVehicleListResource;
use App\Models\SchoolRoutePoints;
use App\Http\Resources\School\Transport\AssignVehicleResource;
use App\Http\Resources\School\Transport\DriverListResource;
use App\Http\Resources\School\Transport\SchoolRoutesListResource;
use App\Http\Resources\School\Transport\SchoolRoutesResource;
use App\Http\Resources\School\Transport\VehicleListResource as TransportVehicleListResource;
use App\Http\Resources\School\Transport\VehicleRouteListResource;
use App\Models\AssignRoute;
use App\Models\Employee;
use App\Models\SchoolRoute;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VechiclesAssignController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $assignRoutes = AssignRoute::where('school_id', $activeSchool->id)->active()->get();
        if ($assignRoutes && count($assignRoutes) > 0) {
            return response([
                'status' => 'success',
                'message' => '',
                'assign_route' => AssignRouteResource::collection($assignRoutes)
            ]);
        } else {
            return response([
                'status' => 'warning',
                'message' => 'No Data Found',
            ]);
        }
    }

    public function getRouteData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $routes = SchoolRoute::where('school_id', $activeSchool->id)->active()->get();

        if ($routes && count($routes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'route_list' => SchoolRoutesListResource::collection($routes),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'route_list' => null,
            'message' => 'No route List  added yet..',
        ]);
    }


    public function getDriverData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $drivers = Employee::where('school_id', $activeSchool->id)->driver()->get();
        if ($drivers && count($drivers) > 0) return response([
            'status' => 'success',
            'message' => '',
            'driver_list' => DriverListResource::collection($drivers),
        ]);

        return response([
            'status' => 'success',
            'message' => 'No Data Found',
            'driver_list' => null,
            'message' => 'No Driver List added yet..'
        ]);
    }


    public function getVehicleData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $vehicles = Vehicle::where('school_id', $activeSchool->id)->with(['latestRoute'])->active()->get();
        if ($vehicles && count($vehicles) > 0) return response([
            'status' => 'success',
            'message' => '',
            'vehicle_list' => TransportVehicleListResource::collection($vehicles),
        ]);

        return response([
            'status' => 'success',
            'message' => 'No Data Found',
            'vehicle_list' => null,
            'message' => 'No Vehicle List added yet..'
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
        $already = AssignRoute::where('school_id', $activeSchool->id)->where('school_route_id', $request->route_id)->where('vehicle_id', $request->vehicle_id)->where('employee_id', $request->driver_id)->active()->first();

        if ($already) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'income information is already exist'
        ]);

        $created = AssignRoute::create([
            'school_id' => $activeSchool->id,
            'school_route_id' => $request->school_route_id,
            'vehicle_id' => $request->employee_id,
            'employee_id' => $request->vehicle_id,
        ]);
        if ($created) {

            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'vehicle route assign successfully',
                'assign_route' => new AssignRouteResource($created)

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Disabled Staff ',
        ]);
    }
    public function getEditData(AssignRoute $AssignRoute)
    {
        return response([
            'status' => 'success',
            'assign_route' => new AssignRouteResource($AssignRoute),
        ]);
    }
    public function updateData(Request $request, AssignRoute $assign_route)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
             $updated = $assign_route->update([
            'school_id' => $activeSchool->id,
            'school_route_id' => $request->school_route_id,
            'vehicle_id' => $request->vehicle_id,
            'employee_id' => $request->employee_id,

        ]);
        if ($updated) {
             $assign_route = AssignRoute::find($assign_route->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'route assign information updated successfully',
                'assign_route' => new AssignRoute($assign_route),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create route assign ',
        ]);
    }
    public function deleteData(AssignRoute $asignroute)
    {
        $deleted = $asignroute->delete();
        if ($deleted) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Route Assign information deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Route Assign information',
        ]);
    }

}
