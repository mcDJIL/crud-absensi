<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{

    protected $karyawanModel;
    public function __construct(Karyawan $karyawan)
    {
        $this->karyawanModel = $karyawan;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = $this->karyawanModel->all();

        return view('admin.karyawan')->with('karyawans', $karyawans);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validation = Validator::make($request->all(), [
        //     'nama' => 'alpha:ascii|required',
        //     'umur' => 'integer|required',
        //     'jabatan' => 'required',
        //     'alamat' => 'required|string'
        // ]);

        // if ($validation->fails())
        // {
        //     return redirect()->to('/admin/karyawan')->withErrors($validation)->withInput();
        // }

        $store = collect($request->only($this->karyawanModel->getFillable()))->toArray();

        $new = $this->karyawanModel->create($store);

        return redirect()->back()->with('success', 'Berhasil menambah data karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());

         return redirect()->back()->with('success', 'Berhasil menambah data karyawan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan, $id)
    {
        $karyawan = $this->karyawanModel->findOrFail($id);
        
        $karyawan->delete();

        return redirect()->back();
    }
}
