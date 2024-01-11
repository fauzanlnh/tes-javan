<?php

namespace App\Http\Controllers\Web;

use App\Models\FamilyTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class FamilyTreeController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familyTrees = FamilyTree::with('parent', 'children')->get();
        return view('index', compact('familyTrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listNames = FamilyTree::select('id', 'name')->get();
        return view('form', compact('listNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => "required",
                'birth_date' => "required",
                'gender' => "required",
                'parent_id' => "required",
            ]);

            if ($validatedData['parent_id'] == '-') {
                $validatedData['parent_id'] = null;
            }

            FamilyTree::create($validatedData);

            return redirect('/')->with('success', 'Orang Berhasil Ditambahkan');
        } catch (ValidationException $e) {
            // If validation fails, return back to the form with the validation errors
            return redirect('/person-create')->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            ddd($e);
            return redirect('/')->with('error', 'Orang Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyTree $familyTree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyTree $familyTree)
    {
        $listNames = FamilyTree::select('id', 'name')->get();
        return view('form', compact('listNames', 'familyTree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FamilyTree $familyTree)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => "required",
                'birth_date' => "required",
                'gender' => "required",
                'parent_id' => "required",
            ]);

            if ($validatedData['parent_id'] == '-') {
                $validatedData['parent_id'] = null;
            }
            $familyTree->update($validatedData);

            return redirect('/')->with('success', 'Orang Berhasil Diubah');
        } catch (ValidationException $e) {
            // If validation fails, return back to the form with the validation errors
            return redirect('/person-edit')->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            ddd($e);
            return redirect('/')->with('error', 'Orang Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyTree $familyTree)
    {
        try {
            $familyTree->delete();
            return redirect('/')->with('success', 'orang Berhasil Dihapus');
        } catch (\Exception $e) {
            ddd($e);
            return redirect('/')->with('error', 'Orang Gagal Dihapus');
        }
    }
}
