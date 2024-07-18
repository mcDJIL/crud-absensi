<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        $karyawans = Karyawan::all();

        $totalKaryawan = $karyawans->count();

        $totalAge = $karyawans->sum('umur');
        $averageAge = number_format($totalAge / $totalKaryawan, 2);

        $month = Carbon::now('Asia/Jakarta')->toDate()->format('m');
        $totalAttendance = Absensi::whereMonth('tanggal', $month)
        ->where('status', 'hadir')
        ->get()
        ->count();

        $monthName = Carbon::now('Asia/Jakarta')->translatedFormat('F');

        return view('user.dashboard', compact('totalKaryawan', 'averageAge', 'monthName', 'totalAttendance'));
    }

    public function showAbsensiPage()
    {
        $karyawans = Karyawan::withCount([
            'absensi as jumlah_hadir' => function ($query) {
                $query->where('status', 'hadir');
            },
            'absensi as jumlah_sakit' => function ($query) {
                $query->where('status', 'sakit');
            },
            'absensi as jumlah_izin' => function ($query) {
                $query->where('status', 'izin');
            },
            'absensi as jumlah_alpa' => function ($query) {
                $query->where('status', 'alpa');
            }
        ])->get();

        return view('user.absensi', compact('karyawans'));
    }
}
