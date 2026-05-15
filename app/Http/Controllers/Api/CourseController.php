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

    public function update(Request $req, $id){

        $course = Course::find($id); 

        if(!$course){
            return response()->json([
                "success"=>false,
                "message"=>"Course not be found!"
            ]);
        }
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
            "message"=> "Course updated successfully!"
        ]);
    }

    public function delete(string $id){
        // Handle course deletion
        $course = Course::findOrFail($id);
        if(!$course){
            return response()->json([
                "success" => false,
                "message" => "Course not found!"
            ]);
        }
        $course->delete();
        return response()->json([
            "success" => true,
            "message" => "Course deleted successfully!"
        ]);
    }

}
