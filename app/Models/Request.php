<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'notes',
        'status',
        'user_admin',
        'no_ticket'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'user_admin');
    }

    public function detail()
    {
        return $this->hasMany(RequestDetail::class, 'request_id','id');
    }
}
