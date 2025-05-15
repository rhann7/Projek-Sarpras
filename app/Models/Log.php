<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id', 'action', 'target', 'target_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}