<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleCreationRequest;
use App\Http\Requests\ModuleUpdateRequest;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Module::all();
        if(count($categories) < 1 ){
            return response(
                [
                    'status' => 'Empty Array',
                    'data' => null
                ],
                200
            );
        }
        // dd($categories);
        return response(
            [
                'status' => 'Success',
                'data' => ModuleResource::collection($categories)
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
    public function store(ModuleCreationRequest $request)
    {
        $category = Module::create(
            $request->all()
        );

        return response(
            [
                'status' => 'Success',
                'data' =>new ModuleResource($category)
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return response(
            [
                'status' => 'Success',
                'data' => new ModuleResource($module)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleUpdateRequest $request, Module $module)
    {
        //
        try{

            $module->name = $request->name;
            $module->description = $request->description;
            $module->course_id = $request->course_id;
            $module->save();

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
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        //
        $module->delete();

        return response(
            [
                'status' => 'Success',
                'Message' => 'SuccesFully deleted'
            ],
            500
        );
    }
}
