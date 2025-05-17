<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\UnitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'unit', 'unit.location'])->latest()->get();

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $borrowings
            ]);
        }

        return view('borrowings.index', compact('borrowings'));
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['user', 'unit', 'unit.location'])->findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json([
                'Data' => $borrowing
            ]);
        }

        return view('borrowings.show', compact('borrowing'));
    }

    public function create()
    {
        return view('borrowings.create');
    }

    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        return view('borrowings.edit', compact('borrowing'));
    }

    public function store(Request $request)
    {
        $rules = [
            'unit_id'      => 'required|exists:unit_items,id',
            'description'  => 'required|string|max:255'
        ];

        $unit = UnitItem::findOrFail($request->unit_id);

        if (!$unit->item->disposable) {
            $rules['borrow_end'] = 'required|date|after:borrow_start';
        }

        $validated = $request->validate($rules);

        if ($unit->status !== 'available') {
            return response()->json([
                'Message' => 'Unit tidak tersedia untuk dipinjam.'
            ], 400);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $borrowing = Borrowing::create($validated);

        $user = $borrowing->user;

        if (request()->expectsJson()) {
            return response()->json([
                'Data'    => $borrowing,
                'User'    => $user->email,
                'Message' => 'Peminjaman berhasil diajukan. Tunggu persetujuan admin.'
            ]);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,returned,rejected'
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $unit = $borrowing->unit;
        $item = $unit->item;

        $status = $validated['status'];

        if ($status === 'approved' && !$item->disposable) {
            $unit->update(['status' => 'borrowed']);
        } else {
            $unit->update(['status' => 'available']);
        }

        $borrowing->update(['status' => $status]);

        if (request()->expectsJson()) {
            return response()->json([
                'Data'    => 'Status ' . $borrowing->status,
                'Message' => 'Status peminjaman berhasil diperbaharui.'
            ]);
        }

        return redirect()->route('borrowings.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}
