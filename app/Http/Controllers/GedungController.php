<?php

namespace App\Http\Controllers;

use App\Imports\GedungImport;
use App\Models\Gedung;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GedungController extends Controller
{
    public function index()
    {
        $gedung = Gedung::all();
        return view('gedung.index', compact('gedung'));
    }

    public function create()
    {
        return view('gedung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);

        Gedung::create($request->all());

        return redirect()->route('gedung.index')
                         ->with('success', 'Data gedung berhasil ditambahkan.');
    }

    public function show(Gedung $gedung)
    {
        return view('gedung.show', compact('gedung'));
    }

    public function edit(Gedung $gedung)
    {
        return view('gedung.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $request->validate([
            'gedung' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);

        $gedung->update($request->all());

        return redirect()->route('gedung.index')
                         ->with('success', 'Data gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();

        return redirect()->route('gedung.index')
                         ->with('success', 'Data gedung berhasil dihapus.');
    }

    public function formImport()
    {
        return view('gedung.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new GedungImport, $request->file('file'));

        return redirect('/gedung')->with('success', 'Data gedung berhasil diimpor.');
    }


    public function getAreasByBuilding(Request $request)
{
    $building = $request->input('building');
    $areas = Gedung::where('gedung', $building)->pluck('area', 'area');
    return response()->json($areas);
}
}