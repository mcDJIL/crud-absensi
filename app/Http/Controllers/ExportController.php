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
}
