<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(){
        $courses = Course::all();
        return CourseResource::collection($courses);
    }

    public function store(Request $req){
        // Handle course enrollment form submission
        // Process the enrollment data and save it to the database
        // return $req;  (for testing purpose)

        $course = new Course(); 
        $course->name = $req->name;
        $course->price = $req->price;
        $course->description = $req->description;
        $file = $req->image;
        if($file){
            $filename = time().'_'.$file->getClientOriginalExtension();
            // $file->move(public_path('course_images'), $filename);   OR
            $file->move("images/", $filename);
            // $course->image = 'images/'.$filename;  OR
            $course->image = "images/$filename";
        }
        $course->save();
        return response()->json([
            "success"=>true,
            "message"=> "Course created successfully!"
        ]);
    }

    // public function delete(string $id){
    //     // Handle course deletion
    //     $course = Course::findOrFail($id);
    //     $course->delete();
    //     return redirect('/courses');
    // }

    // public function update(Request $req, string $id){
    //     $course = Course::findOrFail($id);
    //     $course->title =$req->course_name;
    //     $course->code = $req->course_code;
    //     $file = $req->file('course_image');
    //     if($file){
    //         $filename = time().'_'.$file->getClientOriginalName();
    //         $file->move("images/", $filename);
    //         $course->image = "images/$filename";
    //     }
    //     $course->price = $req->course_price;
    //     $course->duration = $req->course_duration;
    //     $course->save();
    //     return redirect('/courses');
    // }

    // public function edit(string $id){
    //     $course = Course::find($id);
    //     return view('course.edit', compact('course'));
    // }
}
