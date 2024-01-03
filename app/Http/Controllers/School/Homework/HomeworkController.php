<?php

namespace App\Http\Controllers\School\Homework;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Common\SectionListResource;
use App\Http\Resources\School\Homework\HomeworkResource;
use App\Http\Resources\School\Homework\SubjectDropDownResource;
use App\Models\HomeWork;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $homeworks= HomeWork::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($homeworks) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'homeworks' =>HomeworkResource::collection($homeworks),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'homeworks' => null,
            'message' => 'No Homeworks add yet..',
        ]);
    }
    public function getClassSectionSubjectData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $classes= SchoolClass::where('school_id',$activeSchool->id)->allowed()->get();
        $sections= SchoolSection::where('school_id',$activeSchool->id)->allowed()->get();
        $subjects= Subject::where('school_id',$activeSchool->id)->allowed()->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'class_list' => $classes && count($classes) > 0 ? ClassListResource::collection($classes) : null,
            'section_list' => $sections && count($sections) > 0 ? SectionListResource::collection($sections) : null,
            'subject_list' => $subjects && count($subjects) > 0 ? SubjectDropDownResource::collection($subjects) : null,
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
        $image = [];
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Homework/images');
        }
        $homework = HomeWork::where('title',$request->homework_title)->where('subject_id', $request->homework_subject_id)->where('class_id',$request->homework_class_id)->where('section_id',$request->homework_section_id)->where('school_id', $activeSchool->id)->allowed()->first();
        if($homework) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Homeworks already exits'
        ]);
        // $homework_for = [];
        // foreach ( json_decode($request->homework_for) as $key => $value) {
        //     array_push($homework_for, [
        //         'admission_id' => $value,
        //         'evaluation_date' => $value,
        //     ]);
        // }
        // if($request->has('imagePathList')){
        //     $files = array();
        //     $files['path'] = array();
        //     $files['name'] = array();
        //     $files['extension'] = array();

        //     $file_path = null;
        //     $file_name = null;
        //     $file_extension = null;

        //     // foreach ($request->imagePathList as $key => $image) {
        //     //     $file_path = '/storage/' . $value->store('Homework/images/'. $key);
        //     //     array_push($files['path'], $file_path);
        //     //     $file_extension = $request->extensions[$key];
        //     //     array_push($files['extension'], $file_extension);
        //     //     $file_name = $request->imageNameList[$key];
        //     //     array_push($files['name'], $file_name);
        //     // }

        //     $documents = array();

        //     foreach ($request->imagePathList as $key => $image) {
        //         $images = [
        //             'name' => $request->imageNameList[$key],
        //             'type' => $request->extensions[$key],
        //             'path' => '/storage/' . $image->store('homework/documents'),
        //         ];
        //         array_push($documents, $images);
        //     }
        // }

        $created = HomeWork::create([
            'school_id'=> $activeSchool->id,
            'class_id' =>  $request->homework_class_id,
            'section_id' => $request->homework_section_id,
            'subject_id' => $request->homework_subject_id,
            'title' => $request->homework_title,
            'issuing_date' => $request->homework_issue_date,
            'submission_date' => $request->homework_submission_date,
            // 'homework_for' =>  json_encode($homework_for),
            'document' =>$image,
            'description' => $request->homework_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Homework Created Successfully',
                // 'homework' => new HomeworkResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Homework',
        ]);
    }

    public function getEditData(HomeWork $homework)
    {
        return response([
            'status' => 'success',
            'homework' => new HomeworkResource($homework),
        ]);
    }

    public function updateData(Request $request , HomeWork $homework)
    {

        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = HomeWork::where('title',$request->homework_title)->where('subject_id', $request->homework_subject_id)->where('class_id',$request->homework_class_id)->where('section_id',$request->homework_section_id)->where('school_id', $activeSchool->id)->where('id','!=',$homework->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Homeworks already exits'
        ]);
        $image = '';
        if ($homework->document !== null &&  $homework->document !== '' ) {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                Storage::delete($homework->document);
                $image = '/storage/' . $request->image->store('Homework/images');
            }else{
                $image = $homework->document;
            }
        }else{

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Homework/images');
            }else{
                $image = $homework->document;
            }
        }
        // $documents = array();

        // foreach ($request->imagePathList as $key => $image) {
        //     $images = [
        //         'name' => $request->imageNameList[$key],
        //         'type' => $request->extensions[$key],
        //         'path' => '/storage/' . $image->store('homework/documents'),
        //     ];
        //     array_push($documents, $images);
        // }

        $storedHomeworkFor = [];
        $storedEvaluationDate = [];
        foreach(json_decode($homework->homework_for) as $key => $value) {
            array_push($storedHomeworkFor, $value->admission_id);
            array_push($storedEvaluationDate, $value->evaluation_date);
        }


        $homework_for = [];
        foreach ( json_decode($request->homework_for) as $key => $value) {
            $date = null;
            foreach($storedHomeworkFor as $k => $v) {
                if( $value == $v) {
                    $date = $storedEvaluationDate[$k];
                }
            }
            array_push($homework_for, [
                'admission_id' => $value,
                'evaluation_date' => $date,
            ]);
        }
        $update = $homework->update([
            'class_id' =>  $request->homework_class_id,
            'section_id' => $request->homework_section_id,
            'subject_id' => $request->homework_subject_id,
            'title' => $request->homework_title,
            'issuing_date' => $request->homework_issue_date,
            'submission_date' => $request->homework_submission_date,
            'homework_for' =>  json_encode($homework_for),
            'document' => $image,
            'description' => $request->homework_description,
        ]);

        if($update){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Homeworks Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Homeworks',
        ]);
    }

    public function changeStatusData(Request $request, HomeWork $homework)
    {
        $update = $homework->update(['status' => $request->homework_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Enquiries data successfully ' . $request->homework_status,
        ]);

        if ($request->homework_status == 'activated') $message =
            'activate';
        else if ($request->homework_status == 'deactivated') $message =
            'dectivate';
        else if ($request->homework_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

    public function getHomeworkData(HomeWork $homework)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $homework = HomeWork::where('id' , $homework->id)->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'homework' =>new HomeworkResource($homework),
            'message' => '',
        ]);
    }

    public function updateDate(Request $request ,Homework $homework)
    {
        $updateDate = $homework->update([
            'issuing_date' => date('Y-m-d'),
            'submission_date' =>date_format(date_create($request->homework_submission_date),'Y-m-d') ,
        ]);

        if($updateDate){
            $homework = HomeWork::find($homework->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Homework Published Date Updated Successfully',
                'homework' => new HomeworkResource($homework)
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Homework Published Date',
        ]);
    }
    public function updateEvaluationDate(Request $request ,Homework $homework)
    {
        $updateHomeworkFor = [];
        $updateEvaluationDate = [];
        foreach(json_decode($homework->homework_for) as $key => $value) {
            array_push($updateHomeworkFor, $value->admission_id);
            array_push($updateEvaluationDate, $value->evaluation_date);
        }

        $homework_for = [];
        foreach($updateHomeworkFor as $k => $v) {
            $date = null;
            foreach ( json_decode($request->homework_for) as $key => $value) {
                if( $value == $v) {
                    $date = json_decode($request->homework_evaluation_date)[$key];
                }
            }
            array_push($homework_for, [
                'admission_id' => $v,
                'evaluation_date' => $date,
            ]);
        }
        $updateDate = $homework->update([
            'homework_for' =>  json_encode($homework_for),
            // 'evaluation_date' =>json_encode($date),
        ]);

        if($updateDate){
            $homework = HomeWork::find($homework->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Homework Evaluation Date Updated Successfully',
                'homework' => new HomeworkResource($homework)
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Homework Evaluation Date',
        ]);
    }
}
