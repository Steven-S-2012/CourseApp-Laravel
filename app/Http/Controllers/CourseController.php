<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Course;
use App\Lecturer;
use App\Student;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::with(['students','lecturers'])->get();
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
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        return Course::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('students','lecturers');
        return $course;
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
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());
        $course->load('students','lecturers');
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return 'deleted';
    }

    public function addStudent(Course $course, Student $student)
    {
        $course->students()->syncWIthoutDetaching($student);
        $course->load('students','lecturers');
        return $course;
    }

    public function removeStudent(Course $course, Student $student)
    {
        $course->students()->detach($student);
        $course->load('students','lecturers');
        return $course;
    }

    public function addLecturer(Course $course, Lecturer $lecturer)
    {
        $course->students()->syncWIthoutDetaching($lecturer);
        $course->load('students','lecturers');
        return $course;
    }

    public function removeLecturer(Course $course, Lecturer $lecturer)
    {
        $course->students()->detach($lecturer);
        $course->load('students','lecturers');
        return $course;
    }
}
