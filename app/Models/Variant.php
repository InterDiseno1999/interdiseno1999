<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];

    /**
     * Relación con productos.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}