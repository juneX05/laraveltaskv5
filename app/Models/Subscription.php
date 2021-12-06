<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model
{
    use Notifiable;

    protected $fillable = [
        'website_id',
        'email',
    ];

    public function notifiedPosts() {
        return $this->belongsToMany(Post::class, 'notified_posts');
    }
}
