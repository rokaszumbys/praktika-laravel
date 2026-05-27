<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $newCount = Ticket::where('status', 'Naujas')->count();
        $inProgressCount = Ticket::where('status', 'Vykdomas')->count();
        $completedCount = Ticket::where('status', 'Užbaigtas')->count();
        $allTicketsCount = Ticket::count();

        $categories = Category::withCount('tickets')->get();

        $categoryLabels = $categories->pluck('name')->toArray();
        $categoryCounts = $categories->pluck('tickets_count')->toArray();

        return view('dashboard', compact(
            'newCount',
            'inProgressCount',
            'completedCount',
            'allTicketsCount',
            'categoryLabels',
            'categoryCounts'
        ));
    }
}