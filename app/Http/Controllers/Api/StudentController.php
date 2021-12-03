<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required',
            'section_id' => 'required',
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'address' => 'required',
            'photo' => 'required',
            'password' => 'required',
            'gender' => 'required'
        ]);
        $student = Student::create($request->all());
        $student->generatePassword($request->get('password'));
        return response('Student was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::where('id', $id)->firstOrFail();
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::where('id', $id)->firstOrFail();
        $this->validate($request, [
            /*'class_id' => 'required',
            'section_id' => 'required',
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required',
            'photo' => 'required',
            'gender' => 'required',*/
            'email' =>  [
                //'required',
                'email',
                Rule::unique('users')->ignore($student->id),
            ]
        ]);
        $student->update($request->all());
        //$student->generatePassword($request->get('password'));
        return response('Student was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->remove();
        return response('Student was deleted successfully');
    }
}
