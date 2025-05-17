<?php

namespace App\Http\Controllers;

use App\Models\UsedItem;

class UsedItemController extends Controller
{
    public function index()
    {
        $usedItems = UsedItem::with(['user', 'borrowing'])->get();

        if (request()->expectsJson()) {
            return response()->json(['Data' => $usedItems]);
        }

        return view('used.index', compact('usedItems'));
    }

    public function show($id)
    {
        $usedItem = UsedItem::with(['user', 'borrowing'])->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json(['Data' => $usedItem]);
        }

        return view('used.show', compact('usedItem'));
    }
}
