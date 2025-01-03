<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\BookmarkV2;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ 
        'name',
        'email',
        'role',
        'password',
        'phone_number', // Added phone_number to fillable attributes
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [ 
        'password',
        'remember_token',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts () : array
    {
        return [ 
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'name'              => 'string',
            'email'             => 'string',
            'role'              => 'string',
            'phone_number'      => 'string', // Added phone_number to casts
        ];
    }

    /**
     * Get the bookmarks for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks ()
    {
        return $this->hasMany ( Bookmark::class);
    }

    /**
     * Get the bookmarksV2 for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarksV2 ()
    {
        return $this->hasMany ( BookmarkV2::class);
    }
}
