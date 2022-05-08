<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mutation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'product_id',
        'debit',
        'kredit',
        'keterangan',
        'created_at'
    ];

    protected $appends = ['saldo'];


    public function getSaldoAttribute()
    {
    
        return $this->debit - $this->kredit;
    
    }
    public function product()
    {
        return $this->hasOne(User::class, 'id', 'product_id');
    }


    // public function getSaldoAttribute()
    // {
    //     return $this->transactions->sum(function($trans){

    //         return $trans->debit - $trans->kredit;

    //     });
    // }
}
