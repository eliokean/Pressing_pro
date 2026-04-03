<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linge extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'linges';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'nom',
        'categorie',
        'prix',
        'actif',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'prix' => 'integer',
        'actif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les valeurs par défaut des attributs.
     */
    protected $attributes = [
        'actif' => true,
    ];

    // =============================================
    // SCOPES (pour faciliter les requêtes)
    // =============================================

    /**
     * Scope pour filtrer les linges actifs.
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope pour filtrer par catégorie.
     */
    public function scopeCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    /**
     * Scope pour les vêtements.
     */
    public function scopeVetements($query)
    {
        return $query->where('categorie', 'vetement');
    }

    /**
     * Scope pour les articles de maison.
     */
    public function scopeMaison($query)
    {
        return $query->where('categorie', 'maison');
    }

    // =============================================
    // ACCESSORS & MUTATORS
    // =============================================

    /**
     * Accessor pour afficher le prix avec le symbole FCFA.
     */
    public function getPrixFormateAttribute()
    {
        return number_format($this->prix, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Mutator pour s'assurer que le prix est un entier positif.
     */
    public function setPrixAttribute($value)
    {
        $this->attributes['prix'] = max(0, (int) $value);
    }

    // =============================================
    // MÉTHODES UTILITAIRES
    // =============================================

    /**
     * Vérifie si le linge est actif.
     */
    public function estActif(): bool
    {
        return $this->actif;
    }

    /**
     * Active le linge.
     */
    public function activer(): void
    {
        $this->update(['actif' => true]);
    }

    /**
     * Désactive le linge.
     */
    public function desactiver(): void
    {
        $this->update(['actif' => false]);
    }

    /**
     * Retourne la catégorie en français.
     */
    public function getCategorieLibelle(): string
    {
        return $this->categorie === 'Vêtements' ? 'Vêtement' : 'Maison';
    }
}