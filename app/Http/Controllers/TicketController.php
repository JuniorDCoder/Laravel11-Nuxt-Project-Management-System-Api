<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Resources\TicketResource;
use App\Http\Requests\TicketCreateRequest;

class TicketController extends Controller
{
    public function store(TicketCreateRequest $request)
    {
        // Validate the request...
        $data = $request->validated();

        $ticket = Ticket::create($data);

        return new TicketResource($ticket);

    }

    public function show(string $ticket){
        $ticket = Ticket::with('creator', 'members')->findOrFail($ticket);
        return new TicketResource($ticket);
    }

    public function update(TicketCreateRequest $request, Ticket $ticket){
        $data = $request->validated();
        $ticket->update($data);

        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket, Request $request){
        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully']);
    }

    public function assign(Ticket $ticket, Request $request){
        $data = $request->validate([
            'users' => ['required', 'array'],
        ]);
        $users = User::whereIn('email', $data['users'])->select('id', 'email')->get();

        // Send email to those users who are not signed up

        $ticket->members()->sync($users->pluck('id'));
        return new TicketResource($ticket);
    }
}
