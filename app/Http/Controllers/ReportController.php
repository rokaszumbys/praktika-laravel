<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActiveTicketsReportMail;

class ReportController extends Controller
{
    public function activeTicketsPdf()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isSupport()) {
            abort(403);
        }

        $tickets = Ticket::with(['user', 'category'])
            ->where('status', '!=', 'Užbaigtas')
            ->get();

        $pdf = Pdf::loadView('reports.active-tickets', compact('tickets'));

        return $pdf->download('aktyvios-problemos.pdf');
    }
}
public function sendActiveTicketsPdf(Request $request)
{
    if (!Auth::user()->isAdmin() && !Auth::user()->isSupport()) {
        abort(403);
    }

    $request->validate([
        'email' => 'required|email',
    ]);

    $tickets = Ticket::with(['user', 'category'])
        ->where('status', '!=', 'Užbaigtas')
        ->get();

    $pdf = Pdf::loadView('reports.active-tickets', compact('tickets'));

    Mail::to($request->email)->send(new ActiveTicketsReportMail($pdf->output()));

    return redirect()->route('tickets.index')
        ->with('success', 'PDF ataskaita išsiųsta el. paštu.');
}