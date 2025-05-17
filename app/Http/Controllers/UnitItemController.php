<?php

namespace App\Http\Controllers;

use App\Models\UnitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitItemController extends Controller
{
    public function index()
    {
        $units = UnitItem::with('item', 'location')->get();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $units
            ]);
        }

        return view('units.index', compact('units'));
    }

    public function show($id)
    {
        $unit = UnitItem::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $unit
            ]);
        }

        return view('units.show', compact('unit'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function edit($id)
    {
        $unit = UnitItem::findOrFail($id);

        return view('units.edit', compact('unit '));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'     => 'required|exists:items,id',
            'location_id' => 'required|exists:locations,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $units = [];

        for ($i = 0; $i < $validated['quantity']; $i++) {
            do {
                $unitCode = strtoupper(Str::random(6));
            } while (UnitItem::where('unit_code', $unitCode)->exists());

            $units[] = UnitItem::create([
                'item_id'     => $validated['item_id'],
                'location_id' => $validated['location_id'],
                'unit_code'   => $unitCode
            ])->id;
        }

        $createdUnits = UnitItem::with(['item', 'location'])->whereIn('id', $units)->get();

        foreach ($createdUnits as $unit) {
            logActivity(
                'Create',
                'UnitItem',
                $unit->id,
                'Pembuatan unit barang ' . $unit->item->name . ' dengan kode ' . $unit->unit_code . '.'
            );
        }

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $createdUnits,
                'Message' => 'Barang berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('units.index');
    }

    public function update(Request $request, UnitItem $unit)
    {
        $validated = $request->validate([
            'location_id' => 'sometimes|exists:locations,id',
            'condition'   => 'sometimes|in:good,broken',
            'status'      => 'sometimes|in:available,borrowed,used,repaired,lost',
        ]);

        $unit->update($validated);

        logActivity(
            'Update',
            'UnitItem',
            $unit->id,
            'Pembaruan unit barang dengan id ' . $unit->item->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $unit,
                'Message' => 'Barang berhasil diperbaharui.'
            ]);
        }

        return redirect()->route('units.index');
    }

    public function destroy($id)
    {
        $unit = UnitItem::findOrFail($id);
        $unit->delete();

        logActivity(
            'Delete',
            'UnitItem',
            $unit->id,
            'Penghapusan unit barang dengan id ' . $unit->item->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Message' => 'Unit barang berhasil dihapus.'
            ]);
        }

        return redirect()->route('units.index');
    }
}
