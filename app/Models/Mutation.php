<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'debit',
        'kredit',
        'keterangan'
    ];

    public function product()
    {
        return $this->hasOne(User::class, 'id', 'product_id');
    }
}
