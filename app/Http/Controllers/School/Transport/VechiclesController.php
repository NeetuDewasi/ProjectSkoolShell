<?php

namespace App\Http\Controllers\School\Transport;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Http\Resources\School\Transport\SchoolVehicleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VechiclesController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $Vehicles = Vehicle::where('school_id', $activeSchool->id)->active()->get();
        if (count($Vehicles) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'vehicle_no' => SchoolVehicleResource::collection($Vehicles),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'vehicle_no' => null,
            'message' => 'No Vehicle created yet'
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
        $Vehicles = Vehicle::where('vehicle_no', $request->vehicle_no)->where('school_id', $activeSchool->id)->first();

        if ($Vehicles) return response([

            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Vehicles is already exist'
        ]);

        $created = Vehicle::create([
            'school_id' => $activeSchool->id,
            'vehicle_no' => $request->vehicle_no,
            'registration_no' => $request->registration_no,
            'vehicle_model' => $request->vehicle_model,
            'model_year' => $request->model_year,
            'insurance_date' => $request->insurance_date,
            'puc_date' => $request->puc_date,
            'service_date' => $request->service_date,
            'note' => $request->note,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Vehicle created successfully',
                'vehicle_no' => new SchoolVehicleResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Vehicle',
        ]);
    }

    public function updateData(Request $request, Vehicle $Vehicle)
    {
        $updated = $Vehicle->update([
            'vehicle_no' => $request->vehicle_no,
            'vehicle_model' => $request->vehicle_model,
            'model_year' => $request->model_year,
            'driver_name' => $request->driver_name,
            'driver_license' => $request->driver_license,
            'phone' => $request->phone,
            'note' => $request->note,
        ]);
        if ($updated) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Vehicle updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Vehicle',
        ]);
    }

    public function deleteData(Request $request, Vehicle $vehicle)
    {
        $updated = $vehicle->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Vehicle data successfully ' . $request->status,
        ]);

        if ($request->status == 'activated') $message =
            'activate';
        else if ($request->status == 'deactivated') $message =
            'dectivate';
        else if ($request->status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to' . $message,
        ]);
    }
}
