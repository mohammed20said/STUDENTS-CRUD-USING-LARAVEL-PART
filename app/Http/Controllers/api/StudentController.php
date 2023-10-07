<?php

namespace App\Http\Controllers\api;


use App\Models\Students;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students=Students::all();
        if($students->count()>0){
            return response()->json([
                'status'=>200,
                'students'=>$students
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'no records found'
            ],404);
        }
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|max:191',  
            'phone'=>'required|string|max:10',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=>$validator->messages()
            ],422);
        }else{
            $student=Students::create([
                'name'=>$request->name,
                'course'=>$request->course,
                'email'=>$request->email,
                'phone'=>$request->phone,
            ]);

            if($student){
                return response()->json([
                    'status'=>200,
                    'message'=>'Student created successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'something went wrong'
                ],500);
            }
        }
    }


    public function show($id){
        $student=Students::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No student found !!'
            ],404);
        }
    }

    public function edit($id){
        $student=Students::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No student found !!'
            ],404);
        }
    }

    public function update(Request $request,int $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|max:191',  
            'phone'=>'required|string|max:10',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=>$validator->messages()
            ],422);
        }else{
            $student=Students::find($id);
            if($student){
                $student->update([
                    'name'=>$request->name,
                    'course'=>$request->course,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>'student updated successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'student not found'
                ],404);
            }
        }
    }

    public function destroy($id){
        $student=Students::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=>'student deleted successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'student not found'
            ],404);
        }
    }
}
