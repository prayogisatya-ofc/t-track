<?php

namespace App\Http\Controllers;

use App\Models\Tempe;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getGrafikProduksi(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        if (!$start || !$end) {
            $data = Tempe::whereDate('created_at', now())->take(12)->orderBy('created_at', 'desc')->get();
        } else {
            $data = Tempe::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->orderBy('created_at', 'desc')->get();
        }

        $labels = $data->pluck('created_at')->map(function($date) {
            return $date->format('d-m-Y');
        })->toArray();

        $jumlahData = $data->pluck('jumlah')->toArray();

        return response()->json(['labels' => $labels, 'data' => $jumlahData]);
    }

    public function getTotalProduksi(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        if (!$start || !$end) {
            $data = Tempe::whereDate('created_at', now())->sum('jumlah');
        } else {
            $data = Tempe::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->sum('jumlah');
        }

        return response()->json(['totalProduksi' => number_format($data, 0, 0, '.')]);
    }

    public function getSeluruhProduksi()
    {
        $total = Tempe::all()->sum('jumlah');
        if ($total >= 1000000) {
            $total = number_format($total / 1000000, 0) . ' jt';
        } else {
            $total = number_format($total, 0, 0, '.');
        }
        return response()->json(['seluruhProduksi' => $total]);
    }

    public function getGrafikMingguan()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now();

        $data = Tempe::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('W');
            })
            ->map(function ($weekData) {
                return $weekData->sum('jumlah');
            });

        $weeks = [];
        $production = [];
        $total = 0;

        for ($i = 3; $i >= 0; $i--) {
            $weekNumber = Carbon::now()->subWeeks($i)->format('W');
            $weeks[] = "Minggu " . ($i + 1);
            $production[] = $data[$weekNumber] ?? 0;
            $total += $data[$weekNumber] ?? 0;
        }

        return response()->json(['labels' => $weeks, 'data' => $production, 'total' => number_format($total, 0, 0, '.')]);
    }

    public function getRiwayatProduksi(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        if (!$start || !$end) {
            $data = Tempe::whereDate('created_at', now())->take(6)->orderBy('created_at', 'desc')->get();
        } else {
            $data = Tempe::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->orderBy('created_at', 'desc')->get();
        }

        $data->each(function ($item) {
            $item->tanggal = $item->created_at->format('d-m-Y H:i');
        });

        return response()->json(['riwayatProduksi' => $data]);
    }
}
