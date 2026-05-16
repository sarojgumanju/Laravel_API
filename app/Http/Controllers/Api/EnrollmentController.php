<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    public function store(Request $req){
        // return $req;
        // return Hash::make($req->password);

        $validator = Validator::make($req->all(), [
            "course_id" => "required|exists:courses,id",
            "remark" => "nullable|max:255"
        ],
        [
            "course_id.exists"=> "Selected course does not exist.",
        ]);

        if($validator -> fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ]);
        }

        // Enrollment::created([
        //     "user_id" => Auth::user()->id, 
        //     "course_id" => $req->course_id,
        //     "remark" => $req->remark
        // ]);

        $enrollment = new Enrollment();
        $enrollment->user_id = Auth::user()->id;
        $enrollment->course_id = $req->course_id;
        $enrollment->remark = $req->remark;
        $enrollment->save();
        return response()->json([
            'success' => true,
            'message' => 'Enrollment successfull!'
        ]);

    }

    public function index(){
        $enrollments = Enrollment::all();
        return EnrollmentResource::collection($enrollments);
    }

    public function delete(string $id){
        $enrollment = Enrollment::findOrFail($id);
        if(!$enrollment){
            return response()->json([
                "success" => false,
                "message" => "Enrollment not found!"
            ]);
        }
        $enrollment->delete();
        return response()->json([
            "success" => true,
            "message" => "Enrollment deleted successfully!"
        ]);
    }
}
