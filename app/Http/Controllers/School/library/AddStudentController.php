<?php

namespace App\Http\Controllers\School\Library;

use App\Http\Controllers\Controller;
use App\Models\libraryAddLibraryCard;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddStudentController extends Controller
{
    public function saveStudentCard(Request $request)
    {
        dd($request);
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $reck = libraryAddLibraryCard::where('school_id', $activeSchool->id)->where('library_card_no', $request->card_number)->allowed()->first();

        if ($reck) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $created = libraryAddLibraryCard::create([
            'school_id' => $activeSchool->id,
            'student_id' => $request->student_id,
            'library_card_no' => $request->card_number,
        ]);

        if ($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'Card created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);
    }
}
