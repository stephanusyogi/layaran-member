<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Announcement extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'status',
        'published_at',
        'author_id',
    ];

    protected $dates = ['published_at', 'deleted_at'];

    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


}
