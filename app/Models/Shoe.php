<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Shoe extends Model
{
    use HasFactory, SoftDeletes;

    // Daftar atribut yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        'brand_id',
    ];

    // Otomatis set slug ketika name diisi
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Relasi ke Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke Foto sepatu (banyak foto)
    public function photos(): HasMany
    {
        return $this->hasMany(ShoePhoto::class);
    }

    // Relasi ke Ukuran sepatu (banyak ukuran)
    public function sizes(): HasMany
    {
        return $this->hasMany(ShoeSize::class);
    }
}