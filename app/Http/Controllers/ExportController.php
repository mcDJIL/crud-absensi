<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    protected $karyawanModel;
    public function __construct(Karyawan $karyawan)
    {
        $this->karyawanModel = $karyawan;
    }
    
    public function downloadPdf()
    {
        $karyawans = $this->karyawanModel->all();

        $pdf = PDF::loadView('pdf.karyawan', compact('karyawans'));

        return $pdf->download('daftar-karyawan.pdf');
    }

    public function exportAbsen()
    {
        $date = Carbon::now('Asia/Jakarta')->toDateString();

        $absensi = Absensi::where('tanggal', $date)->with('karyawan')->get();

        $pdf = Pdf::loadView('pdf.absensi', compact('absensi', 'date'));

        return $pdf->download('daftar-hadir-' . $date . '.pdf');
    }

    public function rekapAbsen()
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

        $pdf = Pdf::loadView('user.export', compact('karyawans'));

        return $pdf->download('rekap-absensi.pdf');
    }

    public function exportAbsentOnward()
    {
        $date = '2024-07-17';

        $absent = Absensi::where('tanggal', '>=', $date)
        ->orderBy('tanggal')
        ->get()
        ->groupBy('tanggal')
        ->map(function ($item, $tanggal) {
            return [
                'tanggal' => Carbon::parse($tanggal)->format('d-m-Y'),
                'hadir' => $item->where('status', 'hadir')->count(),
                'sakit' => $item->where('status', 'sakit')->count(),
                'izin' => $item->where('status', 'izin')->count(),
                'alpa' => $item->where('status', 'alpa')->count()
            ];
        });

        $total = Absensi::all();
        $totalHadir = $total->where('status', 'hadir')->count();
        $totalSakit = $total->where('status', 'sakit')->count();
        $totalIzin = $total->where('status', 'izin')->count();
        $totalAlpa = $total->where('status', 'alpa')->count();

        $pdf = Pdf::loadView('pdf.absentOnward', compact('absent', 'totalHadir', 'totalSakit', 'totalIzin', 'totalAlpa'));
        return $pdf->download('export-absensi.pdf');
    }
}
