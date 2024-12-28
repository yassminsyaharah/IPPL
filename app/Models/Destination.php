<?php

namespace App\Models;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';

    protected $fillable = [ 
        'name',
        'description',
        'address',
        'province',
        'operating_hours',
        'image_folder_path',
        'ratings',
        'review_count'
    ];

    protected $casts = [ 
        'name'              => 'string',
        'description'       => 'string',
        'address'           => 'string',
        'province'          => 'string',
        'operating_hours'   => 'string',
        'image_folder_path' => 'string',
        'ratings'           => 'float',
        'review_count'      => 'integer'
    ];

    public function bookmarks ()
    {
        return $this->hasMany ( Bookmark::class);
    }
}
