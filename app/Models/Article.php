<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'published_at', 'user_id', 'thumbnail', 'category'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\ArticleImage::class)->orderBy('position');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class)->latest();
    }
}
