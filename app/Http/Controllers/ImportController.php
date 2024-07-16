<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showImportPage()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {

            $validation = Validator::make($request->all(), [
                'file' => 'required|mimes:xls,xlsx,csv'
            ]);

            if ($validation->fails())
            {
                return back()->withErrors($validation)->withInput();
            }

            Excel::import(new KaryawanImport, $request->file('file')->store('files'));

            return back()->with('success', 'Berhasil import file');
   
    }
}
