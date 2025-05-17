<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $categories
            ]);
        }

        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $category
            ]);
        }

        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        logActivity(
            'Create',
            'Category',
            $category->id,
            'Pembuatan kategori ' . $validated['name'] . '.'
        );

        return response()->json([
            'Data' => $category,
            'Message' => 'Kategori berhasil dibuat.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
        ]);

        $category->update($validated);

        logActivity(
            'Update',
            'Category',
            $category->id,
            'Pembaruan kategori dengan id ' . $category->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $category,
                'Message' => 'Kategori berhasil diperbarui.'
            ]);
        }

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        logActivity(
            'Delete',
            'Category',
            $category->id,
            'Penghapusan kategori dengan id ' . $category->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $category,
                'Message' => 'Kategori berhasil dihapus.'
            ]);
        }

        return redirect()->route('categories.index');
    }
}
