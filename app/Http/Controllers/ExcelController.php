<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\TestImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        // dd($request);

        try {
            Excel::import(new TestImport, $file);
            return redirect()->back()->with('succes', 'File successfully imported');
        } catch (\Exception $e) {
            throw new \Exception("Error importing file: " . $e->getMessage());
        }

    }
}
