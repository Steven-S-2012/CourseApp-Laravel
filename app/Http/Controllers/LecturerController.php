<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lecturer::with('courses')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLecturerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLecturerRequest $request)
    {
        return Lecturer::create($request->all());
    }

    /**
     * Display the specified resource
     * with courses relations (load()).
     *
     * @param  \App\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(Lecturer $lecturer)
    {
        $lecturer->load('courses');
        return $lecturer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function edit(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLecturerRequest  $request
     * @param  \App\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLecturerRequest $request, Lecturer $lecturer)
    {
        $lecturer->update($request->all());
        $lecturer->load('courses');
        return $lecturer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return 'deleted';
    }
}
