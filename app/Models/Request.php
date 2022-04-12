<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notes',
        'status',
        'no_ticket'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(RequestDetail::class, 'request_id','id');
    }
}
