<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('tickets.index');
    })->name('dashboard');

    Route::get('/tickets/status/naujas', [TicketController::class, 'newTickets'])
        ->name('tickets.new');

    Route::get('/tickets/status/vykdomas', [TicketController::class, 'inProgressTickets'])
        ->name('tickets.inProgress');

    Route::get('/tickets/status/uzbaigtas', [TicketController::class, 'completedTickets'])
        ->name('tickets.completed');

    Route::resource('tickets', TicketController::class);

    Route::post('/tickets/{ticket}/comments', [TicketCommentController::class, 'store'])
        ->name('tickets.comments.store');

    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])
        ->name('tickets.updateStatus');

    Route::resource('categories', CategoryController::class);

    Route::get('/reports/active-tickets/pdf', [ReportController::class, 'activeTicketsPdf'])
        ->name('reports.activeTicketsPdf');

    Route::post('/reports/active-tickets/send', [ReportController::class, 'sendActiveTicketsPdf'])
        ->name('reports.activeTicketsSend');
});

require __DIR__.'/auth.php';