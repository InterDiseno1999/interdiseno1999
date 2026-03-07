<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Composition extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relación con productos (muchos a muchos)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}