<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Returning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturningController extends Controller
{
    public function index()
    {
        $returnings = Returning::with('borrowing')->get();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $returnings
            ]);
        }

        return view('returnings.index', compact('returnings'));
    }

    public function show($id)
    {
        $return = Returning::findOrFail($id);

        return view('returnings.show', compact('return'));
    }

    public function create()
    {
        return view('returnings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
            'proof_image'  => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('proof_image')) {
            $image = $request->file('proof_image')->store('returns', 'public');
            $validated['proof_image'] = $image;
        }

        $borrowing = Borrowing::with('unit')->findOrFail($validated['borrowing_id']);
        
        $unit = $borrowing->unit;

        if ($unit->item->disposable) {
            return response()->json([
                'message' => 'Barang sekali pakai tidak dapat dikembalikan.'
            ], 422);
        }

        if ($unit->status !== 'borrowed') {
            return response()->json([
                'message' => 'Barang belum dalam status dipinjam atau sudah dikembalikan.'
            ], 400);
        }

        $validated['user_id'] = Auth::id();

        $returning = Returning::create($validated);

        $unit->update(['status' => 'available']);
        $borrowing->update(['status' => 'returned']);

        logActivity(
            'Create',
            'Returning',
            'Returning ID: ' . $borrowing->id,
            'Pengembalian untuk unit dengan kode peminjaman: ' . $borrowing->id . '.'
        );

        if (request()->expectsJson()) {
            return response()->json([
                'Message' => 'Pengembalian berhasil dicatat.',
                'Data' => $returning->load(['borrowing.unit.item', 'user'])
            ]);
        }

        return redirect()->route('returnings.index');
    }
}
