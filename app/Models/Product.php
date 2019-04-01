<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'product_price'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
