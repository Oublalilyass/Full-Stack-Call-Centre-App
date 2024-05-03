<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'call_datetime' => 'required|date',
            'duration' => 'required|integer|min:0',
            'subject' => 'required|string|max:255',
        ]);

        // Create new call record
        $call = Call::create($validatedData);

        // Return response
        return response()->json($call, 201);
    }
}
