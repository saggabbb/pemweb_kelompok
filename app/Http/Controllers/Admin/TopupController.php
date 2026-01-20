<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index()
    {
        // Statistics
        $totalBalance = User::sum('balance'); // Total potential liability
        $pendingRequests = Topup::where('status', 'pending')->count();
        $totalApproved = Topup::where('status', 'approved')->sum('amount');
        $totalRejected = Topup::where('status', 'rejected')->count();

        $topups = Topup::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.topups.index', compact('topups', 'totalBalance', 'pendingRequests', 'totalApproved', 'totalRejected'));
    }

    public function approve(Topup $topup)
    {
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($topup) {
            // Update Topup Status
            $topup->update(['status' => 'approved']);

            // Add Balance to User
            $user = $topup->user;
            $user->balance += $topup->amount;
            $user->save();
        });

        return redirect()->back()->with('success', 'Top-up approved successfully!');
    }

    public function reject(Topup $topup)
    {
        if ($topup->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $topup->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Top-up rejected.');
    }
}
