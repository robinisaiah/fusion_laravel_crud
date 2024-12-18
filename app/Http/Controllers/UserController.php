<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
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
        $validatedData = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|in:Admin,Supervisor,Agent',
            'email' => 'required|email|unique:users,email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'timezone' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors()
            ], 422);
        }

        $storeData = $request->all();

        $storeData['password'] = Hash::make($storeData['password']);

        $user = User::create($storeData);
        Log::info('User created', ['user_id' => $user->id]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validatedData = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|in:Admin,Supervisor,Agent',
            'email' => 'required|email|unique:users,email,' . $id,
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'timezone' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors()
            ], 422);
        }


        $user = User::findOrFail($id);
        $user->update($request->all());
        Log::info('User Updated', ['user_id' => $user->id]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Log::info('User Deleted');

        return response()->json(['message' => 'User deleted successfully']);
    }
}
