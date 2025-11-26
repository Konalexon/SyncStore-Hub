<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_active', 'product_id', 'pinned_message', 'auction_end_time'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
