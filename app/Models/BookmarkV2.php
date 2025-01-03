<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookmarkV2 extends Model
{
    protected $table = 'bookmarks_v2';

    protected $fillable = [ 
        'user_id',
        'place_id'
    ];

    public function user ()
    {
        return $this->belongsTo ( User::class);
    }
}
