<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentDocumentResource;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function saveData(Request $request)
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $image1 = '';
        if ($request->has('image1') && $request->image1 != '') {
            $image1 = '/storage/' . $request->image1->store('students/images');
        }
        $created = StudentDocument::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission,
            'title' => $request->title1,
            'document' => $image1
        ]);
        $image2 = '';
        if ($request->has('image2') && $request->image2 != '') {
            $image2 = '/storage/' . $request->image2->store('students/images');
        }
        $created = StudentDocument::create([
            'school_id' => 1,
            'admission_id' => $request->admission,
            'title' => $request->title2,
            'document' => $image2
        ]);
        $image3 = '';
        if ($request->has('image3') && $request->image3 != '') {
            $image3 = '/storage/' . $request->image3->store('students/images');
        }
        $created = StudentDocument::create([
            'school_id' => 1,
            'admission_id' => $request->admission,
            'title' => $request->title3,
            'document' => $image3
        ]);
        $image4 = '';
        if ($request->has('image4') && $request->image4 != '') {
            $image4 = '/storage/' . $request->image4->store('students/images');
        }
        $created = StudentDocument::create([
            'school_id' => 1,
            'admission_id' => $request->admission,
            'title' => $request->title4,
            'document' => $image4
        ]);

        return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'Document created successfully',

        ]);
    }

    public function getEditData(Request $request)
    {
        $documents = StudentDocument::where('admission_id' , $request->admission_id)->get();

        if($documents && count($documents) > 0) return response([
            'status' => 'success',
            'status_code' => 201,
            'documents' => StudentDocumentResource::collection($documents),
            'message' => '',
        ]);

        return
        response([
            'status' => 'error',
            'status_code' => 300,
            'documents' => null,
            'message' => 'Data no found',
        ]);
    }
    public function updateData(Request $request)
    {
        foreach ($request->ids as $index => $value) {
            if($index == 0){
                $docs = StudentDocument::where('id' , $value)->first();
                $image1  = $docs->document;
                if ($request->hasFile('image1') && $request->image1 != null && $request->image1 != '') {
                    if ($docs->document != null) {
                        Storage::delete($docs->document);
                    }
                    $image1 = '/storage/' . $request->image1->store('students/images');
                }
                $updated1 = $docs->update([
                    'title' => $request->title1,
                    'document' => $image1
                ]);

            }
        }
        if ($index == 1) {
            $docs = StudentDocument::where('id', $value)->first();
            $image2  = $docs->document;
            if ($request->hasFile('image2') && $request->image2 != null && $request->image2 != '') {
                if ($docs->document != null) {
                    Storage::delete($docs->document);
                }
                $image2 = '/storage/' . $request->image2->store('students/images');
            }
            $updated = $docs->update([
                'title' => $request->title2,
                'document' => $image2
            ]);
        }

        if ($index == 2) {
            $docs = StudentDocument::where('id', $value)->first();
            $image3  = $docs->document;
            if ($request->hasFile('image3') && $request->image3 != null && $request->image3 != '') {
                if ($docs->document != null) {
                    Storage::delete($docs->document);
                }
                $image3 = '/storage/' . $request->image3->store('students/images');
            }
            $updated = $docs->update([
                'admission_id' => $request->admission,
                'title' => $request->title3,
                'document' => $image3
            ]);
        }
        if ($index == 3) {
            $docs = StudentDocument::where('id', $value)->first();
            $image4  = $docs->document;
            if ($request->hasFile('image4') && $request->image4 != null && $request->image4 != '') {
                if ($docs->document != null) {
                    Storage::delete($docs->document);
                }
                $image4 = '/storage/' . $request->image4->store('students/images');
            }
            $updated = $docs->update([
                'admission_id' => $request->admission,
                'title' => $request->title4,
                'document' => $image4
            ]);
        }

        if($updated1){
            return response([
                'status' => 'success',
                'message' => 'data updated successfully.',
            ]);
        }
    }

}
