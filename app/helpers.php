<?php

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logActivity')) {
    function logActivity(string $action, string $target, int $targetId, ?string $description = null): void
    {
        Log::create([
            'user_id'     => Auth::id() ?? null,
            'action'      => $action,
            'target'      => $target,
            'target_id'   => $targetId,
            'description' => $description,
        ]);
    }
}