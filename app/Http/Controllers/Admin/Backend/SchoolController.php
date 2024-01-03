<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\School\AdminSchoolDocResource;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\School\SchoolGroupSelectResource;
use App\Http\Resources\Admin\School\SchoolResource;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\SchoolGroup;
use App\Models\School;
use App\Models\SchoolDocument;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{

    public function getGroups()
    {
        $groups = SchoolGroup::active()->get();
        if (count($groups) > 0)
            return response([
                'status_code' => 200,
                'status' => 'success',
                'groups' => SchoolGroupSelectResource::collection($groups)
            ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'groups' => null,
            'message' => 'No group created yet'
        ]);
    }
    public function getSchools()
    {
        $users = User::with('school')->where('role_id','2')->get();
        if (count($users) > 0)
            return response([
                'status_code' => 200,
                'status' => 'success',
                'schools' => UserResource::collection($users)
            ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'schools' => null,
            'message' => 'No school created yet'
        ]);
    }

    public function getDocuments($school_list_id)
    {
        $school = School::where('id', $school_list_id)->first();
        if ($school) {
            return response([
                'status_code' => 200,
                'status' => 'success',
                'schoolDoc' =>new AdminSchoolDocResource($school),
            ]);
        }
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'schoolDocs' => null,
            'message' => 'No school created yet',
        ]);
    }

    public function saveData(Request $request)
    {
        $schoolAdmin = User::create([
            'name' => $request->school_name,
            'email' => $request->email_id,
            'role_id' => 2,
            'password' =>  Hash::make($request->password),
            'password_text' =>  $request->password,
        ]);
        if ($schoolAdmin) {
            $school = School::where('name', $request->school_name)->first();
            if ($school) return response([
                'status' => 'warning',
                'status_code' => 300,
                'message' => 'This School is already exist'
            ]);
            $activationKey = Str::random(10);
            $create = School::create([
                'user_id' => $schoolAdmin->id,
                'school_group_id' => $request->group_id,
                'name' => $request->school_name,
                'contact_person_name' => $request->contact_person,
                'mobile' => $request->mobile_number,
                'alternative_mobile' => $request->alternative_mobile_number,
                'email' => $request->email_id,
                'alternative_email' => $request->alternative_email_id,
                'password' => Hash::make($request->password),
                'current_address_line1' =>  $request->current_address_line1,
                'current_address_line2' => $request->current_address_line2,
                'current_location' => $request->current_location,
                'current_landmark' => $request->current_landmark,
                'current_city' => $request->current_city,
                'current_pincode' => $request->current_pincode,
                'current_state' => $request->current_state,
                'current_country' => $request->current_country,
                'permanent_address_line1' =>  $request->permanent_address_line1,
                'permanent_address_line2' => $request->permanent_address_line2,
                'permanent_location' => $request->permanent_location,
                'permanent_landmark' => $request->permanent_landmark,
                'permanent_city' => $request->permanent_city,
                'permanent_pincode' => $request->permanent_pincode,
                'permanent_state' => $request->permanent_state,
                'permanent_country' => $request->permanent_country,
                'activation_key' => $activationKey,
                'status' => 'activated'

            ]);
        }
        if ($create) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'school created successfully',
                'school' => new SchoolResource($create),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create school',
        ]);
    }
    public function getSchoolEdit($edit_id)
    {
        $school = School::where('id', $edit_id)->first();

        if ($school)
            return response([
                'status_code' => 200,
                'status' => 'success',
                'school' => new SchoolResource($school),
            ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'No school created yet',
        ]);
    }
    public function saveSchoolDocuments(Request $request)
    {

        $imagePaths = [];
        foreach ($request->file('images') as $index => $image) {
            $title = $request->input('titles.' . $index, null);

            $path = '/storage/images/' . $image->store('images');

            $imagePaths[] = ['document' => $path, 'school_id' => $request->school_id, 'title' => $title];
        }
        SchoolDocument::insert($imagePaths);

        return response()->json(['status' => 'success',
            'status_code' => 201,
            'message' => 'Images uploaded successfully']);

        return response([
            'status' => 'warning',
            'status_code' => 201,
            'message' => 'Error',
        ]);
    }
    public function getItemEdit($edit_id)
    {
        $school = School::where('id', $edit_id)->with('schoolDocuments')->first();
        if ($school) {
            return response([
                'status_code' => 200,
                'status' => 'success',
                'schoolDoc' => new AdminSchoolDocResource($school),
            ]);
        }
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'schoolDocs' => null,
            'message' => 'No school created yet',
        ]);
    }
    public function updateSchool(Request $request, School $school)
    {
            $update_school = $school->update([
                'user_id' => $school->user_id,
                'school_group_id' => $request->group_id,
                'name' => $request->school_name,
                'contact_person_name' => $request->contact_person,
                'mobile' => $request->mobile_number,
                'alternative_mobile' => $request->alternative_mobile_number,
                'email' => $request->email_id,
                'alternative_email' => $request->alternative_email_id,
                'password' => Hash::make($request->password),
                'password_text' => $request->password,
                'current_address_line1' =>  $request->current_address_line1,
                'current_address_line2' => $request->current_address_line2,
                'current_location' => $request->current_location,
                'current_landmark' => $request->current_landmark,
                'current_city' => $request->current_city,
                'current_pincode' => $request->current_pincode,
                'current_state' => $request->current_state,
                'current_country' => $request->current_country,
                'is_same_address' => $request->is_permanent,
                'permanent_address_line1' =>  $request->permanent_address_line1,
                'permanent_address_line2' => $request->permanent_address_line2,
                'permanent_location' => $request->permanent_location,
                'permanent_landmark' => $request->permanent_landmark,
                'permanent_city' => $request->permanent_city,
                'permanent_pincode' => $request->permanent_pincode,
                'permanent_state' => $request->permanent_state,
                'permanent_country' => $request->permanent_country,
                'activation_key' => $school->activation_key,
                'status' => 'activated'
            ]);

        if ($update_school) {
            $user = User::where('id',$school->user_id)->first();
            if(!$user)
                return response([
                    'status' => 'error',
                    'status_code' => 400,
                    'message' => 'User not available',
                ]);
            $update_user = $user->update([
                'name' => $request->school_name,
                'email' => $request->email_id,
                'password' => $request->password,
                'password' => Hash::make($request->password),
                'password_text' => $request->password,
            ]);

            if($update_user)
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'school Updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create school',
        ]);
    }

    public function updateSchoolDocuments(Request $request, $id)
    {
        $school = School::findOrFail($id);

        // Update existing documents
        $existingTitles = $request->input('existing_titles', []);
        $existingFiles = $request->file('existing_files', []);

        foreach ($existingTitles as $index => $title) {
            // Find the corresponding document using the index or any unique identifier
            $existingDocument = $school->schoolDocuments()->where('id', $index)->first();

            if ($existingDocument) {
                // Update the existing document
                $existingDocument->update([
                    'title' => $title,
                ]);

                // Check if a new file is provided for the existing document
                if (isset($existingFiles[$index])) {
                    $newFile = $existingFiles[$index];
                    $existingDocument->document = $newFile->store('images', 'public');

                    $existingDocument->save();
                }
            }
        }

        // Add new documents
        $newTitles = $request->input('titles', []);
        $newImages = $request->file('images', []);

        foreach ($newTitles as $index => $newTitle) {
            $newImage = $newImages[$index];

            // Save the new document
            $newDocument = new SchoolDocument([
                'title' => $newTitle,
            ]);

            $newDocument->document = $newImage->store('images', 'public');

            $school->schoolDocuments()->save($newDocument);
        }

        return response([
            'status' => 'success',
            'message' => 'School documents updated successfully',
        ], 200);
    }
    public function downloadDocument($documentId)
{
    $document = SchoolDocument::findOrFail($documentId);

    // Ensure the document exists in the storage
    if (Storage::exists($document->document)) {
        // Get the original file name
        $originalFileName = pathinfo($document->document, PATHINFO_BASENAME);

        // Return a response with a download link
        return response()->json([
            'download_link' => route('download.document', ['documentId' => $documentId]),
        ]);
    }

    // Handle if the file doesn't exist
    return response()->json(['error' => 'File not found'], 404);
}
    public function deleteStatusSchool(Request $request, $schoolId)
    {
        $school = School::find($schoolId);
        $user = User::where('id',$school->user_id)->first();

        $school_updated = $school->delete();
        $user_updated = $user->delete();
        if ($school_updated && $user_updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'School successfully ' . $request->status,
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
    public function changeStatusDeleted(Request $request, SchoolDocument $schoolDocument)
    {
        Storage::delete($schoolDocument->document);
        $deleted = $schoolDocument->delete();

        if ($deleted) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'School Document successfully deleted' ,
        ]);

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to delete',
        ]);
    }
}



