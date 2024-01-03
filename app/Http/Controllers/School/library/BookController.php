<?php

namespace App\Http\Controllers\School\library;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Library\LibraryBookCategoryDropdownResource;
use App\Http\Resources\School\Library\LibraryBookReckDropdownResource;
use App\Http\Resources\School\Library\LibraryBookResource;
use App\Models\LibraryBook;
use App\Models\LibraryBookCategory;
use App\Models\LibraryBookReck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $books = LibraryBook::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($books) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'books' => LibraryBookResource::collection($books),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'books' => null,
            'message' => 'No Employees add yet..',
        ]);
    }
    public function getDropdownListData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $category_list = LibraryBookCategory::where('school_id',$activeSchool->id)->allowed()->get();
        $reck_list = LibraryBookReck::where('school_id',$activeSchool->id)->allowed()->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'category_list' => ($category_list && count($category_list) > 0) ? LibraryBookCategoryDropdownResource::collection($category_list) : null,
            'reck_list' => ($reck_list && count($reck_list) > 0) ? LibraryBookReckDropdownResource::collection($reck_list) : null,
            'message' => '',
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
        $book_cover = '';
        if ($request->has('book_cover') && $request->book_cover != '') {
            $book_cover = '/storage/' . $request->book_cover->store('library/books');
        }
        $book = LibraryBook::where('code', $request->book_code)->first();

        if ($book) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $created = LibraryBook::create([
            'school_id' => $activeSchool->id,
            'category_id' => $request->category_id,
            'reck_id' => $request->reck_id,
            'shelf_number'=>$request->shelf_number,
            'code'=>$request->book_code,
            'title'=>$request->book_title,
            'author' => $request->book_author,
            'cost' => $request->book_cost,
            'fine' => $request->fine_on_lost,
            'inventory_date' => $request->inventory_date,
            'cover' => $book_cover,
            'isbn_number'=>$request->isbn_number,
            'quantity' => $request->quantity,
            'publisher' => $request->publisher,
        ]);

        if ($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'reck' => new LibraryBookResource($created),
            'message' => 'Book created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);
    }
}
