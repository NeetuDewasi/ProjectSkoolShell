<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentTransportResource;
use App\Http\Resources\School\Student\TransportResource;
use App\Http\Resources\School\Student\RouteListDropdownResource;
use App\Models\SchoolRoute;
use App\Models\StudentTransport;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\Transport;
use Illuminate\Http\Request;

class StudentTransportController extends Controller
{

    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $transports = SchoolRoute::where('school_id', $activeSchool->id)->active()->get();
        if (count($transports) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'routes' => TransportResource::collection($transports),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'routes' => null,
            'message' => 'No routes created yet'
        ]);
    }
    public function getRoute()
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $routeList = SchoolRoute::where('school_id', $activeSchool->id)->get();

        if ($routeList && count($routeList) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'route_list' => RouteListDropdownResource::collection($routeList),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'route_list' => null,
            'message' => 'No Route added yet..',
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
        $StudentTransport = StudentTransport::where('admission_id', $request->admission)->where('school_id', $activeSchool->id)->first();

        if ($StudentTransport) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Transport is already exist'
        ]);
        $created = StudentTransport::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission_id,
            'is_transport' => $request->is_transport,
            'school_route_id' => $request->school_route_id,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Transport created successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Transport  ',
        ]);
    }
    public function getEditItemData(Request $request)
    {
        $studentTransport = StudentTransport::where('admission_id', $request->admission)->first();
        if ($studentTransport) return response([
            'status' => 'success',
            'status_code' => 200,
            'edit_transport' => new StudentTransportResource($studentTransport),
            'message' => ''
        ]);

        return response([
            'status' => 'error',
            'edit_transport' => null,
            'message' => ''
        ]);
    }
    public function updateData(Request $request, StudentTransport $studentTransport)
    {
        $update = $studentTransport->update([
            'school_route_id' => $request->school_route_id,
            'is_transport' => $request->is_transport,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Transport updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Transport  ',
        ]);
    }
};

