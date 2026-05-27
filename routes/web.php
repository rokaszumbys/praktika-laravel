<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

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

    Route::get('/admin-test', function () {
        return view('admin-test');
    })->name('admin.test');
});

require __DIR__.'/auth.php';