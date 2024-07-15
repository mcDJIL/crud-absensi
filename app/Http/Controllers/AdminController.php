<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $karyawanModel;
    public function __construct(Karyawan $karyawan)
    {
        $this->karyawanModel = $karyawan;
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
