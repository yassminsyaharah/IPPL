<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = [ 
        'user_id',
        'destination_id',
    ];

    protected function casts () : array
    {
        return [ 
            'user_id'        => 'integer',
            'destination_id' => 'integer',
        ];
    }

    public function user ()
    {
        return $this->belongsTo ( User::class);
    }

    public function destination ()
    {
        return $this->belongsTo ( Destination::class);
    }
}
