<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    // Display rekap data view with data from the layanans table
    public function rekapData()
    {
        $nidn = Auth::user()->username;
    
        $dosen = Dosen::where('nidn', $nidn)->first();
        $data = Layanan::where('nidn', $nidn)
            ->whereIn('verifikasi', ['approved', 'rejected'])  // Fetch both approved and rejected records
            ->get();
    
        // Debugging
        Log::info('Data retrieved:', $data->toArray()); // Log data to check what is retrieved
        
        return view('dosen.rekapdata', compact('data'));
    
    }
}