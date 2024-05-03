<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the supervisors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all supervisors from the database
        $supervisors = Supervisor::all();

        // Return the supervisors as a JSON response
        return response()->json($supervisors);
    }

    /**
     * Store a newly created supervisor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:supervisors,email',
        ]);

        // Create a new supervisor instance
        $supervisor = new Supervisor([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Save the supervisor to the database
        $supervisor->save();

        // Return a success response with the created supervisor data
        return response()->json($supervisor, 201);
    }

    public function show($id)
    {
        // Find the supervisor by id
        $supervisor = Supervisor::findOrFail($id);

        // Return the supervisor as a JSON response
        return response()->json($supervisor);
    }

    /**
     * Update the specified supervisor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the supervisor by id
        $supervisor = Supervisor::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:supervisors,email,' . $id,
        ]);

        // Update the supervisor data
        $supervisor->name = $request->name;
        $supervisor->email = $request->email;

        // Save the updated supervisor to the database
        $supervisor->save();

        // Return a success response with the updated supervisor data
        return response()->json($supervisor);
    }

    /**
     * Remove the specified supervisor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the supervisor by id
        $supervisor = Supervisor::findOrFail($id);

        // Delete the supervisor from the database
        $supervisor->delete();

        // Return a success response
        return response()->json(null, 204);
    }
    /**
     * Register a new supervisor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response 
     * */

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors,email',
            'password' => 'required|string|min:6',
        ]);

        // Create a new supervisor record
        $supervisor = Supervisor::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Generate a token for the new supervisor
        $token = $supervisor->createToken('SupervisorToken')->plainTextToken;

        return response()->json(['supervisor' => $supervisor, 'token' => $token], 201);
    }
    /**
     * Login a supervisor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the supervisor
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $supervisor = Auth::user();
            $token = $supervisor->createToken('SupervisorToken')->plainTextToken;

            return response()->json(['supervisor' => $supervisor, 'token' => $token], 200);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


}
