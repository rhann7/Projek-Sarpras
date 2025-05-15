<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedItem extends Model
{
    protected $fillable = ['borrowing_id', 'user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
