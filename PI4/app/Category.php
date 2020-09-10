<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable =['name','home'];

    public function products()
    {
        Return $this->hasMany(Product::class, 'category_id');
    }
}
