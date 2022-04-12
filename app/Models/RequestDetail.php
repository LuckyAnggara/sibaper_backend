<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'product_id',
        'quantity',
    ];

    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
