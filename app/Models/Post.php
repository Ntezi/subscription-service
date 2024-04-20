<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'email_sent', // Add other fields as necessary
    ];

    /**
     * Get the website that owns the post.
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}
