<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['eatery_id', 'user_id', 'rating', 'body'];

    public function eatery()
    {
        return $this->belongsTo(Eatery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}