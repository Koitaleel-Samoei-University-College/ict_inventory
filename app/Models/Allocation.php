<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allocation extends Model
{
    use HasFactory;
    protected $fillable = ['staff_id', 'office_id', 'item_id', 'user_id'];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
