<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    /**
     * Get the users that belong to the website.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_website');
    }

    /**
     * Get the posts for the website.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
