<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';

    protected $fillable = [ 
        'name',
        'description',
        'address',
        'province',
        'opening_hour',
        'closing_hour',
        'photo_folder',
    ];

    protected function casts () : array
    {
        return [ 
            'name'         => 'string',
            'description'  => 'string',
            'address'      => 'string',
            'province'     => 'string',
            'opening_hour' => 'datetime',
            'closing_hour' => 'datetime',
            'photo_folder' => 'string',
        ];
    }

    public function bookmarks ()
    {
        return $this->hasMany ( Bookmark::class);
    }
}
