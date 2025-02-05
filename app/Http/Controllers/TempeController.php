<?php

namespace App\Http\Controllers;

use App\Models\Tempe;
use Illuminate\Http\Request;

class TempeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric'
        ]);

        Tempe::create([
            'jumlah' => $request->jumlah
        ]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }
}
