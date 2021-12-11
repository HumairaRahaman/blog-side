<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFall(mixed $blog_id)
 */
class blog extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'url',
        'image',
        'image_alt',
        'meta',
        'short_description',
        'description',
        'active',
    ];

    //Blogs Belongs to user
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    //Blogs Belongs to category
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    //Blogs have Many Tags
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

}
