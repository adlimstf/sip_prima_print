<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {

        $years = Transaksi::selectRaw('YEAR(created_at) year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year', now()->year);

        $selectedYearCorunt = $request->query('year-c', now()->year);

        $countTransaksi = Transaksi::whereNotIn('status', ['make'])->count();

        $transaksiRetur = Transaksi::with('return_transaksi')
            ->whereHas('return_transaksi', function ($query) {
                $query->whereNotNull('id'); // Assuming 'id' is the primary key in 'return_transaksi'
            })
            ->count();

        $countuser = User::where('role', 'admin')->count();

        $transaksis = Transaksi::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
            ->whereNotIn('status', ['make'])
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $transaksis_count = Transaksi::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereNotIn('status', ['make'])
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');


        $monthlyData = array_fill(1, 12, 0); // [1 => 0, 2 => 0, ..., 12 => 0]
        $monthlyDataCount = array_fill(1, 12, 0); // [1 => 0, 2 => 0, ..., 12 => 0]


        foreach ($transaksis as $month => $total) {
            $monthlyData[$month] = $total;
        }
        foreach ($transaksis_count as $month => $total) {
            $monthlyDataCount[$month] = $total;
        }

        return view('admin.dashboard', compact('years', 'selectedYear', 'selectedYearCorunt', 'monthlyData', 'monthlyDataCount', 'countTransaksi', 'countuser', 'transaksiRetur'));
    }

    public function printChart(Request $request)
    {
        $years = Transaksi::selectRaw('YEAR(created_at) year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year', now()->year);


        $transaksis = Transaksi::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
            ->whereNotIn('status', ['make'])
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $transaksis_count = Transaksi::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereNotIn('status', ['make'])
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');


        $monthlyData = array_fill(1, 12, 0); // [1 => 0, 2 => 0, ..., 12 => 0]
        $monthlyDataCount = array_fill(1, 12, 0); // [1 => 0, 2 => 0, ..., 12 => 0]


        foreach ($transaksis as $month => $total) {
            $monthlyData[$month] = $total;
        }
        foreach ($transaksis_count as $month => $total) {
            $monthlyDataCount[$month] = $total;
        }

        return view('admin.print', compact('years', 'selectedYear', 'monthlyData', 'monthlyDataCount'));
    }
}
