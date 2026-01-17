<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Daftar order yang ditugaskan ke courier
     */
    public function index()
    {
        return view('courier.dashboard');
    }
}
