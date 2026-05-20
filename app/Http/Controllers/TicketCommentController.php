<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCommentAdded;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->isSupport() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'comment' => 'required',
        ]);

        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

Mail::to($ticket->user->email)->send(new TicketCommentAdded($ticket, $comment));

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Komentaras pridėtas.');
    }
}