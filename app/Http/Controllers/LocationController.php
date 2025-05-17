<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $locations
            ]);
        }

        return view('locations.index', compact('locations'));
    }

    public function show($id)
    {
        $location = Location::findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $location
            ]);
        }

        return view('locations.show', compact('location'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);

        return view('locations.edit', compact('location'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = Location::create($validated);

        logActivity(
            'Create',
            'Location',
            $location->id,
            'Pembuatan lokasi ' . $validated['name'] . '.'
        );

        return response()->json([
            'Data' => $location,
            'Message' => 'Lokasi berhasil dibuat.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
        ]);

        $location->update($validated);

        logActivity(
            'Update',
            'Location',
            $location->id,
            'Pembaruan lokasi dengan id ' . $location->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $location,
                'Message' => 'Lokasi berhasil diperbarui.'
            ]);
        }

        return redirect()->route('locations.index');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        logActivity(
            'Delete',
            'Location',
            $location->id,
            'Penghapusan lokasi dengan id ' . $location->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $location,
                'Message' => 'Lokasi berhasil dihapus.'
            ]);
        }

        return redirect()->route('locations.index');
    }
}
