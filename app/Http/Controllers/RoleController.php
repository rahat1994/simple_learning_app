<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleAssigningRequest;
use App\Http\Requests\RoleCreationRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $roles = Role::all();

        if(count($roles) < 1 ){
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
                'data' => RoleResource::collection($roles)
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
    public function store(RoleCreationRequest $request)
    {
        $role = Role::create(
            $request->all()
        );

        return response(
            [
                'status' => 'Success',
                'data' =>new RoleResource($role)
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        return response(
            [
                'status' => 'Success',
                'data' => new RoleResource($role)
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        try{

            $role->name = $request->name;
            $role->save();

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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response(
            [
                'status' => 'Success',
                'Message' => 'SuccesFully deleted'
            ],
            500
        );
    }

    public function assign_role(RoleAssigningRequest $request){

        try {
            $user = User::findOrFail($request->user_id);

            $user->role = $request->role;
            $user->save();
            return response(
                [
                    'status' => 'Success',
                    'Message' => 'SuccesFully Added User Role'
                ],
                500
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
}
