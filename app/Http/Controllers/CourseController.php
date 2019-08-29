<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'scopes:manage-courses']); //,'scopes:create-course' ,'can:create' 'can:create,App\Course',
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["data"=>Course::all()],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        // dd($request->json()->all());

        $data = Course::create($request->json()->all());
        if($data)
        {
            return response()->json(['data'=>$data],200);
        }
        return response()->json(['error'=>'failed to insert']);
        
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {

        return response()->json(['data'=>$course],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        // dd(request()->all());
        $rules = [
                        'course_name'   =>  'required|string|max:100',
                        'image'   =>  'required|string|max:100',
                        'description'   =>  'required|string',
                        'duration'   =>  'required|string',
                        'fee'   =>  'required',
                        'added_by'   =>  'required|integer',

                    ];

        // $validator = Validator::make(Input::all(), $rules);
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $success = $course->update($request->all());

        if($success) {
            return response()->json(['success'=>$request->all()],200);
        }else{
            return response()->json(['error'=>'failed to update']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
