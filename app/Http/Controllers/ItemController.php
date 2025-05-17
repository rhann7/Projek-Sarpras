<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->withCount('unit')->get();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $items
            ]);
        }

        return view('items.index', compact('items'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $item
            ]);
        }

        return view('items.show', compact('item'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('items.edit', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'origin'      => 'required|string|max:255',
            'disposable'  => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('items', 'public');
            $validated['image'] = $image;
        }

        $item = Item::create($validated);

        logActivity(
            'Create',
            'Item',
            $item->id,
            'Pembuatan barang ' . $validated['name']
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $item,
                'Message' => 'Item berhasil dibuat.'
            ]);
        }

        return redirect()->route('items.index');
    }
}
