<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamAnalytics extends Model
{
    use HasFactory;

    protected $fillable = ['live_stream_id', 'viewer_count'];

    public function stream()
    {
        return $this->belongsTo(LiveStream::class, 'live_stream_id');
    }
}
