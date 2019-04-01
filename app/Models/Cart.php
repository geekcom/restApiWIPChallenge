<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'cart_total_amount'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'cart_id')->with('product');
    }
}
