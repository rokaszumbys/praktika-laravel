<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketStatusChanged;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['user', 'category'])
        ->latest()
        ->get();

    $pageTitle = 'Visi bilietai';

    $newCount = Ticket::where('status', 'Naujas')->count();
    $inProgressCount = Ticket::where('status', 'Vykdomas')->count();
    $completedCount = Ticket::where('status', 'Užbaigtas')->count();

    return view('tickets.index', compact(
        'tickets',
        'pageTitle',
        'newCount',
        'inProgressCount',
        'completedCount'
    ));
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Naujas',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Bilietas sukurtas sėkmingai.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'comments.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();

        return view('tickets.edit', compact('ticket', 'categories'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Bilietas atnaujintas.');
    }

    public function destroy(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Bilietas pašalintas.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->isSupport() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));
        
        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Bilieto būsena pakeista.');
    }
    public function newTickets()
    {
    $tickets = Ticket::with(['user', 'category'])
        ->where('status', 'Naujas')
        ->latest()
        ->get();

    $pageTitle = 'Nauji bilietai';

    $newCount = Ticket::where('status', 'Naujas')->count();
    $inProgressCount = Ticket::where('status', 'Vykdomas')->count();
    $completedCount = Ticket::where('status', 'Užbaigtas')->count();

    return view('tickets.index', compact(
        'tickets',
        'pageTitle',
        'newCount',
        'inProgressCount',
        'completedCount'
    ));
    }

    public function inProgressTickets()
    {
    $tickets = Ticket::with(['user', 'category'])
        ->where('status', 'Vykdomas')
        ->latest()
        ->get();

    $pageTitle = 'Vykdomi bilietai';

    return view('tickets.index', compact('tickets', 'pageTitle'));
    }

    public function completedTickets()
    {
    $tickets = Ticket::with(['user', 'category'])
        ->where('status', 'Užbaigtas')
        ->latest()
        ->get();

    $pageTitle = 'Užbaigti bilietai';

    return view('tickets.index', compact('tickets', 'pageTitle'));
    }
}