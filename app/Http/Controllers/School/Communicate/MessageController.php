<?php

namespace App\Http\Controllers\School\Communicate;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Resources\School\Communication\SendMessageResource;


class MessageController extends Controller
{
    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $created = Message::create([
            'school_id' => $activeSchool->id,
            'user_id' => $authUser->id,
            'school_class_id' => $request->class,
            'published_at' => date_format(date_create($request->published_at), 'Y-m-d'),
            'description' => $request->description,

        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Content created successfully',
                'send_message' => new SendMessageResource($created),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Message',
        ]);
    }
}
