<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // Nom (obligatoire, texte court)
        'price',         // Prix (obligatoire, nombre décimal positif)  
        'description',   // Détails (texte long, optionnel)
        'image',         // Image (obligatoire - jpg, png, max 2Mo)
        'category',      // Catégorie (bonus)
        'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthode pour obtenir l'URL de l'image
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    // Catégories disponibles
    public static function getCategories()
    {
        return [
            'electronique' => 'Électronique',
            'vetements' => 'Vêtements',
            'maison' => 'Maison & Jardin',
            'sports' => 'Sports & Loisirs',
            'livres' => 'Livres',
            'alimentation' => 'Alimentation',
            'beaute' => 'Beauté & Santé',
            'automobile' => 'Automobile',
            'autres' => 'Autres'
];
}
}