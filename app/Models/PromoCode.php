<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'code',
    'discount_amount',
    // kalau ada kolom lain juga tambahkan
];

}
