<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', function () {
        return redirect()->route('tickets.index');
    })->name('dashboard');

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
