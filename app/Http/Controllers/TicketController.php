<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets, Response::HTTP_OK);
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json($ticket, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'status' => 'string|in:open,closed',
        ]);

        $ticket = Ticket::create([
            'subject' => $request->input('subject'),
            'description' => $request->input('description'),
            'status' => $request->input('status', 'open'),
        ]);

         // Notify supervisors about the new ticket
        $supervisors = Supervisor::all();
        foreach ($supervisors as $supervisor) {
        $supervisor->notify(new TicketNotification($ticket));
    }


        return response()->json($ticket, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'string',
            'description' => 'string',
            'status' => 'string|in:open,closed',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return response()->json($ticket, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
