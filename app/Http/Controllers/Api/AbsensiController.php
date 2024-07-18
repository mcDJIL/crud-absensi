<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{

    protected $absensiModel;
    public function __construct(Absensi $absensi)
    {
        $this->absensiModel = $absensi;
    }

    public function getTotalAbsent()
    {
        $hadir = $this->absensiModel->where('status', 'hadir')->get()->count();
        $sakit = $this->absensiModel->where('status', 'sakit')->get()->count();
        $izin = $this->absensiModel->where('status', 'izin')->get()->count();
        $alpa = $this->absensiModel->where('status', 'alpa')->get()->count();

        $absent = [
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'alpa' => $alpa,
        ];

        return response()->json(['absent' => $absent]);
    }

    public function getAbsentOnward()
    {
        $date = '2024-07-17';

        $dataAbsent = Absensi::where('tanggal', '>=', $date)
        ->orderBy('tanggal')
        ->get()
        ->groupBy('tanggal')
        ->map(function ($items, $tanggal) {
            return [
                'tanggal' => Carbon::parse($tanggal)->format('d-F'),
                'hadir' => $items->where('status', 'hadir')->count(),
                'sakit' => $items->where('status', 'sakit')->count(),
                'izin' => $items->where('status', 'izin')->count(),
                'alpa' => $items->where('status', 'alpa')->count(),
            ];
        })
        ->values();

        return response()->json([ 'data' => $dataAbsent ], 200);
    }

    public function bestEmployee()
    {
        $bestEmployee = Karyawan::withCount([
            'absensi as hadir_count' => function ($query) {
                $query->where('status', 'hadir');
            },
            'absensi as sakit_count' => function ($query) {
                $query->where('status', 'sakit');
            },
            'absensi as izin_count' => function ($query) {
                $query->where('status', 'izin');
            },
            'absensi as alpa_count' => function ($query) {
                $query->where('status', 'alpa');
            }
            ])->orderBy('hadir_count', 'desc')->first();

        return response()->json([ 'best_employee' => $bestEmployee ], 200);
    }

}
