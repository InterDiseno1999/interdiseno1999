<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden llenar masivamente.
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'width',
        'has_design',
        'stock',
    ];

    /**
     * Cast de atributos para asegurar tipos de datos correctos al acceder.
     */
    protected $casts = [
        'stock' => 'boolean',
        'has_design' => 'boolean',
    ];

    /**
     * Relación muchos a muchos con Composiciones.
     * Permite que una tela tenga varias fibras.
     */
    public function compositions()
    {
        return $this->belongsToMany(Composition::class)->withTimestamps();
    }

    /**
     * Relación muchos a muchos con Variantes.
     */
    public function variants()
    {
        return $this->belongsToMany(Variant::class)
                    ->withPivot('variant_image')
                    ->withTimestamps();
    }
}