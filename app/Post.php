<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Post extends Moloquent {
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'content',
        'short_content',
        'published',
        'published_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published_at' => 'datetime'];
}
