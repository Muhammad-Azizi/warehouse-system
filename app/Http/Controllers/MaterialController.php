<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('material_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('storage_bin', 'like', "%{$search}%");
            });
        }

        $materials = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_number' => 'required|string|max:100|unique:materials,material_number',
            'description' => 'required|string|max:255',
            'qty_stock' => 'required|integer|min:0',
            'uom' => 'required|string|max:20',
            'storage_bin' => 'required|string|max:50',
        ]);

        Material::create($validated);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_number' => 'required|string|max:100|unique:materials,material_number,' . $material->id,
            'description' => 'required|string|max:255',
            'qty_stock' => 'required|integer|min:0',
            'uom' => 'required|string|max:20',
            'storage_bin' => 'required|string|max:50',
        ]);

        $material->update($validated);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material berhasil dihapus.');
    }
}