<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{

    protected $karyawanModel;
    protected $absensiModel;
    public function __construct(Karyawan $karyawan, Absensi $absensi)
    {
        $this->karyawanModel = $karyawan;
        $this->absensiModel = $absensi;
    } 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = Carbon::now('Asia/Jakarta')->toDateString();

        // Mengambil semua data karyawan dengan absensi pada tanggal tertentu jika ada
        $karyawans = Karyawan::with(['absensi' => function ($query) use ($date) {
            $query->where('tanggal', $date);
        }])->get();

        return view('admin.absensi')->with('karyawans', $karyawans);
    }

    public function clockIn(Request $request, $id)
    {
        $karyawan = $this->karyawanModel->where('id', $id)->first();

        $date = Carbon::now('Asia/Jakarta')->toDateString();
        $time = Carbon::now('Asia/Jakarta')->toDateTime()->format('H:i:s');

        $absent = collect($request->only($this->absensiModel->getFillable()))
        ->put('id_karyawan', $karyawan->id)
        ->put('tanggal', $date)
        ->put('jam_masuk', $time)
        ->put('jam_keluar', null)
        ->put('status', 'hadir')
        ->toArray();

        $new = $this->absensiModel->create($absent);

        return redirect()->route('admin.absensi');
    }

    public function clockOut(Request $request, $id)
    {
        $absensi = $this->absensiModel->findOrFail($id);

        $time = Carbon::now('Asia/Jakarta')->toDateTime()->format('H:i:s');

        $absensi->update([ 'jam_keluar' => $time ]);

        return redirect()->route('admin.absensi');
    }

    public function notPresent(Request $request, $id)
    {
        $karyawan = $this->karyawanModel->findOrFail($id);

        $date = Carbon::now('Asia/Jakarta')->toDateString();

        $absent = collect($request->only($this->absensiModel->getFillable()))
        ->put('id_karyawan', $karyawan->id)
        ->put('tanggal', $date)
        ->put('status', $request->status)
        ->toArray();

        $new = $this->absensiModel->create($absent);

        return redirect()->route('admin.absensi');
    }
}
