<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseModuleResource;
use App\Models\CourseModule;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $modules = CourseModule::all();
        // dd($categories);
        return response(
            [
                'status' => 'Success',
                'data' => CourseModuleResource::collection($modules)
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
    public function store(Request $request)
    {
        //
        $modules = CourseModule::create(
            $request->all()
        );

        return response(
            [
                'status' => 'Success',
                'data' =>new CourseModuleResource($modules)
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function show(CourseModule $courseModule)
    {
        //
        return response(
            [
                'status' => 'Success',
                'data' => new CourseModuleResource($courseModule)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseModule $courseModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseModule $courseModule)
    {
        //
        try{

            $courseModule->name = $request->name;
            $courseModule->description = $request->description;
            $courseModule->is_active = (isset($request->is_active)) ? $request->is_active :$courseModule->is_active;
            $courseModule->course_id = $request->parent;
            $courseModule->save();

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
     * @param  \App\Models\CourseModule  $courseModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseModule $courseModule)
    {
        //
        $courseModule->delete();

        return response(
            [
                'status' => 'Success',
                'Message' => 'SuccesFully deleted'
            ],
            500
        );
    }
}
