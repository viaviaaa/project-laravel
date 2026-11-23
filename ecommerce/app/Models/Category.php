<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom apa aja yang boleh diisi langsung
    protected $fillable = ['name', 'slug'];

    // Satu kategori bisa punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
  
        }
  
}