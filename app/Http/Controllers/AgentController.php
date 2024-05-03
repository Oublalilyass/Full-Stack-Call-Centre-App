<?php
/// app/Http/Controllers/AgentController.php
namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        // Retrieve all agents
        $agents = Agent::all();

        // Return agents as JSON response
        return response()->json($agents);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
        ]);

        // Create new agent record
        $agent = Agent::create($validatedData);

        // Return response
        return response()->json($agent, 201);
    }

    public function update(Request $request, Agent $agent)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
        ]);

        // Update agent record
        $agent->update($validatedData);

        // Return updated agent as JSON response
        return response()->json($agent);
    }

    public function destroy(Agent $agent)
    {
        // Delete agent record
        $agent->delete();

        // Return empty response with status code 204 (No Content)
        return response()->json(null, 204);
    }
}
