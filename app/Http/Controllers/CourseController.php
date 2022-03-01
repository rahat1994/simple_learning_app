<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreationRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Pricing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Course::all();
        // dd($categories);
        return response(
            [
                'status' => 'Success',
                'data' => CourseResource::collection($categories)
            ],
            200
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCreationRequest $request)
    {
        $course = Course::create($request->all());
        //
        // $pricing = Pricing::create([
        //     'price'=> $request->price->amount,
        //     'currency' => $request->price->currency,
        //     'course_id' =>$course->id,
        // ]);



        return response(
            [
                'status' => 'Success',
                'data' =>new CourseResource($course)
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
                //
        return response(
            [
                'status' => 'Success',
                'data' => new CourseResource($course)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        //

        try{
            
            $course->name = $request->name;
            $course->description = $request->description;
            $course->category_id = (isset($request->category_id)) ? $request->category_id : $course->category_id;
            $course->is_active = (isset($request->is_active))? $request->is_active : $course->is_active;
            $course->price = (isset($request->price))? $request->price : $course->price;
            $course->currency = (isset($request->currency))? $request->currency : $course->currency;
            $course->save();

           return response(
                [
                    'status' => 'Success',
                    'Message' => 'Succesfully Updated'
                ],
                200
            );

        } catch(Exception $e){
            Log::error($e->getMessage());

            return response(
                    [
                        'status' => 'Error',
                        'Message' => 'Something went wrong'
                    ],
                    500
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
                //
        $course->delete();

        return response(
            [
                'status' => 'Success',
                'Message' => 'SuccesFully deleted'
            ],
            500
        );
    }
}
