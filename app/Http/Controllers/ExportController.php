<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
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
}
