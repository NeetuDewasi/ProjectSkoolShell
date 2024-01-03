<?php

namespace App\Http\Controllers\School\Communicate;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Communication\NoticeBoardResource;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class NoticeBoardController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $notice_board = NoticeBoard::where('school_id', $activeSchool->id)->active()->get();
        if (count($notice_board) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'noticeBoard' => NoticeBoardResource::collection($notice_board),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'notice_board' => null,
            'message' => 'No notice created yet'
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
        $notice = NoticeBoard::where('school_id', $activeSchool->id)->where('title', $request->title)->first();
        if ($notice) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Notice is already exist'
        ]);
        $created = NoticeBoard::create([
            'school_id' => $activeSchool->id,
            'title' => $request->title,
            'description' => $request->description,
            'notice_on'=> $request->notice_on,
            'publish_on' => $request->publish_on,
            'message_for' => json_encode($request->message_for),
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Notice created successfully',
                'notice_board' => new NoticeBoardResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Notice',
        ]);
    }
    public function getEditItemData(NoticeBoard $noticeBoard)
    {
        return response([
            'status' => 'success',
            'status_code' => 200,
            'edited_notice' => new NoticeBoardResource($noticeBoard),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, NoticeBoard $noticeBoard)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $update = $noticeBoard->update([
            'school_id' => $activeSchool->id,
            'title' => $request->title,
            'description' => $request->description,
            'notice_on' => $request->notice_on,
            'publish_on' => $request->publish_on,
            'message_for' => json_encode($request->message_for),
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Notice Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update upload Notice',
        ]);
    }
    public function viewPageData(NoticeBoard $noticeBoard)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $noticeBoard = NoticeBoard::where('id', $noticeBoard->id)->allowed()->first();
        if ($noticeBoard)  return response([
            'status' => 'success',
            'status_code' => 200,
            'viewNotice' => new NoticeBoardResource($noticeBoard),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'noticeBoard' => null,
            'message' => 'No notice created yet'
        ]);
    }
    public function changeStatusData(Request $request, NoticeBoard $noticeBoard)
    {
        $updated = $noticeBoard->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Notice Board successfully ' . $request->status,
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
};
