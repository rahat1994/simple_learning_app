<?php

namespace App\Http\Controllers;

use App\Http\Library\RoleHelpers;
use App\Http\Requests\CategoryCreationRequest;
use App\Http\Requests\CategoryDeletionRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use RoleHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $categories = Category::all();
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
                'data' => CategoryResource::collection($categories)
            ],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryCreationRequest $request)
    {
        //

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreationRequest $request)
    {
        $category = Category::create(
            $request->all()
        );

        return response(
            [
                'status' => 'Success',
                'data' =>new CategoryResource($category)
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //


        return response(
            [
                'status' => 'Success',
                'data' => new CategoryResource($category)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {


        try{

            $category->name = $request->name;
            $category->description = $request->description;
            $category->parent = $request->parent;
            $category->save();

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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryDeletionRequest $request, Category $category)
    {
        return response(
            [
                'status' => 'Success',
                'Message' => 'SuccesFully deleted'
            ],
            500
        );
    }
}
