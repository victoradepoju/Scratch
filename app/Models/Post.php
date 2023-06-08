<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    protected $casts = [
        'body' => 'array'
    ];

    protected $appends = [
        'title_upper_case'
    ];

    // if we name any model function to start with 'get' and end with 'Attribute',
    // laravel will take the function as an Accessor
    public function getTitleUpperCaseAttribute(): string
    {
        return strtoupper($this->title);
    }

    // if we name any model function to start with 'set' and end with 'Attribute',
    // laravel will take the function as an Accessor
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = strtolower($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }
}
