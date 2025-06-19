<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected $appends = ['total_items', 'completed_items'];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->items()->count();
    }

    public function getCompletedItemsAttribute()
    {
        return $this->items()->where('status', 'selesai')->count();
    }
}
