<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api','scopes:manage-students']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->authorize('viewAny','App\Student')) {

            return response()->json(['students'=>Student::all()],200);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // var_dump($request->json()->all());die;
        if($this->authorize('create','App\Student')) {

            $rules = [
                            'name'   =>  'required|string|max:100',
                            'email'   =>  'required|email|max:100',
                            'phone_no'   =>  'required|numeric|min:10',
                            'father_name'   =>  'required|string',
                            'course_id'   =>  'required|numeric',
                            'joined_date'   =>  'required|date',

                        ];

            $validator = Validator::make($request->json()->all(), $rules);

            if($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $success = Student::create($request->json()->all());

            if($success) {
                return response()->json(['success'=>$request->json()->all()],200);
            }else {
                return response()->json(['error'=>'failed to register']);
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if($this->authorize('update', $student))
        {
            $rules = [
                            'name'   =>  'required|string|max:100',
                            'email'   =>  'required|email|max:100',
                            'phone_no'   =>  'required|numeric|min:10',
                            'father_name'   =>  'required|string',
                            'course_id'   =>  'required|numeric',
                            'joined_date'   =>  'required|date',

                        ];

            $validator = Validator::make($request->json()->all(), $rules);

            if($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $student->find($student->id);
            $success = $student->Update($request->json()->all());

            if($success) {
                return response()->json(['success'=>$request->json()->all()],200);
            }else {
                return response()->json(['error'=>'failed to update']);
            }




        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if($this->authorize('delete', $student))
        {
            // $student = Student::find($student->id);
            if($student->delete())
            {
                return response()->json(['success'=>true],200);
            }
        }
    }
}
