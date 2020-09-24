<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name'
        ,'image'
        ,'desc'
        ,'price'
        ,'discount'
        ,'category_id'
        ,'stock'
        ,'home'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discountPrice()
    {
        return $this->fMoney($this->price * (1-$this->discount/100));
     }

     public function price()
     {
         return $this->fMoney($this->price);
     }

     public function fMoney($value)
     {
         return 'R$'.number_format($value, 2,',','.');
     }

     public function descontoExibir()
     {
         return number_format($this->discount, 2) . '%';
     }
}
