<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_id',
        'type_id',
    ];

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id')->withTrashed();
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id')->withTrashed();
    }
}
