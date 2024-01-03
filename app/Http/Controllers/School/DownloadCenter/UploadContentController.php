<?php

namespace App\Http\Controllers\School\DownloadCenter;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\DownloadCenter\UploadContentResource;
use App\Models\Content;
use App\Models\UploadContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UploadContentController extends Controller
{

    public function getData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        if($request->content_type && $request->content_type != null && $request->content_type != ''){
            $contents = Content::where('school_id', $activeSchool->id)->where('content_type', $request->content_type)->with(['schoolClass', 'schoolSection'])->allowed()->get();
        }else{
            $contents = Content::where('school_id', $activeSchool->id)->with(['schoolClass', 'schoolSection'])->allowed()->get();

        }
        if (count($contents) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'contents' => UploadContentResource::collection($contents),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'contents' => null,
            'message' => 'No content created yet'
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
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('uploadContent/images');
        }

        $created = Content::create([
            'school_id' => $activeSchool->id,
            'user_id' => $authUser->id,
            'school_class_id' => $request->class,
            'school_section_id' => $request->section != -1 ? $request->section : null,
            'content_type' => $request->content_type,
            'title' => $request->title,
            'content_for' => json_encode($request->content_for),
            'is_publish' => $request->is_publish,
            'published_at' => $request->published_at,
            'description' => $request->description,
            'documents' => json_encode($image),
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Content created successfully',
                'upload_contents' => new UploadContentResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Content',
        ]);
    }
    public function getContentData(Content $content)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $content = Content::where('id', $content->id)->with(['schoolClass', 'schoolSection'])->allowed()->first();

        if ($content) return response([
            'status' => 'success',
            'status_code' => 200,
            'content' => new UploadContentResource($content),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'content' => null,
            'message' => 'No content created yet'
        ]);
    }
    public function getEditItemData(Content $content)
    {
        return response([
            'status' => 'success',
            'status_code' => 200,
            'upload_content' => new UploadContentResource($content),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, Content $content)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $image = '';
        if ($request->hasFile('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('content/images');
        }

        $update = $content->update([
            'school_id' => $activeSchool->id,
            'user_id' => $authUser->id,
            'school_class_id' => $request->class,
            'school_section_id' => $request->section != -1 ? $request->section : null,
            'content_type' => $request->content_type,
            'title' => $request->title,
            'content_for' => json_encode($request->content_for),
            'published_at' => date_format(date_create($request->published_at), 'Y-m-d'),
            'description' => $request->description,
            'documents' => json_encode($image),
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Contents Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update upload Content',
        ]);
    }
    public function changeStatusData(Request $request, Content $content)
    {
        if($request->status == 'deleted'){
            $updated = $content->update(['status' => $request->status]);
        }else if($request->status == 'published'){
            $updated = $content->update(['status' => $request->status , 'published_at' => date('Y-m-d')]);
        }
        else{
            $updated = $content->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        }
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Content successfully ' . $request->status,
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
