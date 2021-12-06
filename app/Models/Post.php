<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'website_id',
        'title',
        'description',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function scopeGetNotifiablePosts($query)
    {
        $condition = function ($query) {
            $query->whereDoesntHave('notifiedPosts', function ($query) {
                $query->where('notified_posts.post_id', '!=', 'posts.id');
            });
        };
        return $query->whereHas('website', function ($query) use ($condition) {
            $query->whereHas('subscriptions', $condition);
        })->with(['website' => function ($query) use ($condition) {
            $query->with(['subscriptions' => $condition]);
        }])->get();
    }
}
