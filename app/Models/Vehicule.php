<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'vehicules';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'type',
        'coefficient',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'coefficient' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =============================================
    // CONSTANTES (types de véhicules)
    // =============================================

    public const TYPE_VELO = 'velo';
    public const TYPE_MOTO = 'moto';
    public const TYPE_VOITURE = 'voiture';

    public const TYPES = [
        self::TYPE_VELO,
        self::TYPE_MOTO,
        self::TYPE_VOITURE,
    ];

    public const LIBELLES_TYPES = [
        self::TYPE_VELO => 'Vélo',
        self::TYPE_MOTO => 'Moto',
        self::TYPE_VOITURE => 'Voiture',
    ];

    // =============================================
    // SCOPES (pour faciliter les requêtes)
    // =============================================

    /**
     * Scope pour filtrer par type de véhicule.
     */
    public function scopeDeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour les vélos.
     */
    public function scopeVelo($query)
    {
        return $query->where('type', self::TYPE_VELO);
    }

    /**
     * Scope pour les motos.
     */
    public function scopeMoto($query)
    {
        return $query->where('type', self::TYPE_MOTO);
    }

    /**
     * Scope pour les voitures.
     */
    public function scopeVoiture($query)
    {
        return $query->where('type', self::TYPE_VOITURE);
    }

    /**
     * Scope pour les véhicules avec un coefficient minimum.
     */
    public function scopeCoefficientMin($query, float $min)
    {
        return $query->where('coefficient', '>=', $min);
    }

    /**
     * Scope pour les véhicules avec un prix base maximum.
     */
    public function scopePrixBaseMax($query, int $max)
    {
        return $query->where('prix_base', '<=', $max);
    }

    // =============================================
    // ACCESSORS & MUTATORS
    // =============================================

    /**
     * Accessor pour obtenir le libellé du type.
     */
    public function getTypeLibelleAttribute(): string
    {
        return self::LIBELLES_TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Accessor pour obtenir le prix de base formaté.
     */
    public function getPrixBaseFormateAttribute(): string
    {
        return number_format($this->prix_base, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accessor pour calculer le prix total (prix_base * coefficient).
     */
    public function getPrixTotalAttribute(): float
    {
        return $this->prix_base * $this->coefficient;
    }

    /**
     * Accessor pour le prix total formaté.
     */
    public function getPrixTotalFormateAttribute(): string
    {
        return number_format($this->prix_total, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Mutator pour s'assurer que le coefficient est positif.
     */
    public function setCoefficientAttribute($value)
    {
        $this->attributes['coefficient'] = max(0.01, (float) $value);
    }

    /**
     * Mutator pour s'assurer que le prix_base est positif.
     */
    public function setPrixBaseAttribute($value)
    {
        $this->attributes['prix_base'] = max(0, (int) $value);
    }

    // =============================================
    // MÉTHODES UTILITAIRES
    // =============================================

    /**
     * Vérifie si le véhicule est un vélo.
     */
    public function estVelo(): bool
    {
        return $this->type === self::TYPE_VELO;
    }

    /**
     * Vérifie si le véhicule est une moto.
     */
    public function estMoto(): bool
    {
        return $this->type === self::TYPE_MOTO;
    }

    /**
     * Vérifie si le véhicule est une voiture.
     */
    public function estVoiture(): bool
    {
        return $this->type === self::TYPE_VOITURE;
    }

    /**
     * Calcule le prix pour une distance donnée.
     */
    public function calculerPrixPourDistance(float $distance): float
    {
        return $this->prix_base * $this->coefficient * $distance;
    }

    /**
     * Calcule le prix pour une distance formaté.
     */
    public function calculerPrixPourDistanceFormate(float $distance): string
    {
        return number_format($this->calculerPrixPourDistance($distance), 0, ',', ' ') . ' FCFA';
    }

    /**
     * Retourne la liste des types disponibles pour les formulaires.
     */
    public static function getTypesPourSelect(): array
    {
        return self::LIBELLES_TYPES;
    }
}