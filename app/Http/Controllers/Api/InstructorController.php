<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructorRequest;
use App\Models\Instructor;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('viewAny');

        $this->authorize('viewAny', Instructor::class);

        return response()->json(Instructor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructorRequest $request)
    {
        $this->authorize('create', Instructor::class);

        $instructor = Instructor::create($request->validated());

        return response()->json(['instructor' => $instructor], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        $this->authorize('viewAny', $instructor);

        return response()->json($instructor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstructorRequest $request, Instructor $instructor)
    {
        $this->authorize('update', Instructor::class);

        $instructor->update($request->validated());

        return response()->json($instructor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructor)
    {
        $this->authorize('delete', Instructor::class);

        $instructor->delete();

        return response()->json('instructor delete successfuly');
    }
}
