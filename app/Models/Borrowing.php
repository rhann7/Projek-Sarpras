<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id', 'description', 'borrow_end', 'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitItem::class);
    }

    public function returning()
    {
        return $this->hasOne(Returning::class);
    }

    public function used()
    {
        return $this->hasOne(UsedItem::class);
    }
}
