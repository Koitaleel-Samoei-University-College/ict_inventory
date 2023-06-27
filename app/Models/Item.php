<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['model', 'description', 'serial_number', 'item_category_id'];


    public function item_category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
