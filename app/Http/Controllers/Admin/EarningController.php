<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class EarningController extends Controller
{
    public function index()
    {
        $totalEarnings = 0;
        $thisMonth = 0;
        $lastMonth = 0;
        $earnings = [];
        
        return view('admin.earnings.index', compact('totalEarnings', 'thisMonth', 'lastMonth', 'earnings'));
    }
}
