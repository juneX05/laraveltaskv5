<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'name', 'description', 'domain', 'owners_name', 'owners_email',
        'owners_phone'
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
