<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        $karyawans = Karyawan::all();

        $totalKaryawan = $karyawans->count();

        $totalAge = $karyawans->sum('umur');
        $averageAge = $totalAge / $totalKaryawan;

        $month = Carbon::now('Asia/Jakarta')->toDate()->format('m');
        $totalAttendance = Absensi::whereMonth('tanggal', $month)
        ->where('status', 'hadir')
        ->get()
        ->count();

        $monthName = Carbon::now('Asia/Jakarta')->translatedFormat('F');

        return view('admin.dashboard', compact('totalKaryawan', 'averageAge', 'monthName', 'totalAttendance'));
    }
}
