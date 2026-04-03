<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContrainteTemps extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'contrainte_temps';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'label',
        'coefficient',
        'actif',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'coefficient' => 'decimal:2',
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
    // CONSTANTES (labels prédéfinis)
    // =============================================

    public const LABEL_PLUIE = 'Pluie';
    public const LABEL_NUIT = 'Nuit';
    public const LABEL_FORTE_PLUIE = 'Pluie forte';
    public const LABEL_MATIN = 'Matin';
    public const LABEL_APRES_MIDI = 'Brouillard';

    public const LABELS_PAR_DEFAUT = [
        self::LABEL_PLUIE,
        self::LABEL_NUIT,
        self::LABEL_FORTE_PLUIE,
        self::LABEL_MATIN,
        self::LABEL_APRES_MIDI,

    ];

    // =============================================
    // SCOPES
    // =============================================

    /**
     * Scope pour les contraintes actives.
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope pour les contraintes inactives.
     */
    public function scopeInactif($query)
    {
        return $query->where('actif', false);
    }

    /**
     * Scope pour filtrer par label.
     */
    public function scopeDeLabel($query, string $label)
    {
        return $query->where('label', $label);
    }

    /**
     * Scope pour les contraintes avec un coefficient minimum.
     */
    public function scopeCoefficientMin($query, float $min)
    {
        return $query->where('coefficient', '>=', $min);
    }

    /**
     * Scope pour les contraintes avec un coefficient maximum.
     */
    public function scopeCoefficientMax($query, float $max)
    {
        return $query->where('coefficient', '<=', $max);
    }

    // =============================================
    // ACCESSORS & MUTATORS
    // =============================================

    /**
     * Accessor pour obtenir le coefficient formaté en pourcentage.
     */
    public function getCoefficientPourcentageAttribute(): string
    {
        return ($this->coefficient * 100) . '%';
    }

    /**
     * Accessor pour obtenir le coefficient avec son signe.
     */
    public function getCoefficientFormateAttribute(): string
    {
        $operation = $this->coefficient >= 1 ? '+' : '-';
        $valeur = abs(($this->coefficient - 1) * 100);
        return $operation . $valeur . '%';
    }

    /**
     * Accessor pour le label avec première lettre en majuscule.
     */
    public function getLabelFormateAttribute(): string
    {
        return ucfirst($this->label);
    }

    /**
     * Mutator pour s'assurer que le coefficient est valide.
     */
    public function setCoefficientAttribute($value)
    {
        // Le coefficient doit être positif et raisonnable (entre 0.1 et 5)
        $value = max(0.1, min(5.0, (float) $value));
        $this->attributes['coefficient'] = round($value, 2);
    }

    /**
     * Mutator pour le label (nettoie et formate).
     */
    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = ucfirst(trim($value));
    }

    // =============================================
    // MÉTHODES UTILITAIRES
    // =============================================

    /**
     * Vérifie si la contrainte est active.
     */
    public function estActif(): bool
    {
        return $this->actif;
    }

    /**
     * Active la contrainte.
     */
    public function activer(): void
    {
        $this->update(['actif' => true]);
    }

    /**
     * Désactive la contrainte.
     */
    public function desactiver(): void
    {
        $this->update(['actif' => false]);
    }

    /**
     * Calcule le prix après application du coefficient.
     */
    public function appliquerCoefficient(float $prix): float
    {
        return round($prix * $this->coefficient, 2);
    }

    /**
     * Calcule le prix formaté après application du coefficient.
     */
    public function appliquerCoefficientFormate(float $prix): string
    {
        $resultat = $this->appliquerCoefficient($prix);
        return number_format($resultat, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Vérifie si le coefficient augmente le prix.
     */
    public function augmentePrix(): bool
    {
        return $this->coefficient > 1;
    }

    /**
     * Vérifie si le coefficient diminue le prix.
     */
    public function diminuePrix(): bool
    {
        return $this->coefficient < 1;
    }

    /**
     * Retourne l'impact du coefficient en texte.
     */
    public function getImpactTexte(): string
    {
        if ($this->coefficient > 1) {
            $hausse = ($this->coefficient - 1) * 100;
            return "Augmentation de {$hausse}%";
        } elseif ($this->coefficient < 1) {
            $baisse = (1 - $this->coefficient) * 100;
            return "Réduction de {$baisse}%";
        }
        return "Pas d'impact";
    }

    /**
     * Retourne la liste des labels pour les formulaires.
     */
    public static function getLabelsPourSelect(): array
    {
        return self::query()
            ->actif()
            ->orderBy('label')
            ->pluck('label', 'id')
            ->toArray();
    }

    /**
     * Seed les contraintes par défaut.
     */
    public static function seedParDefaut(): void
    {
        $defaults = [
            ['label' => 'Pluie', 'coefficient' => 1.3],
            ['label' => 'Nuit', 'coefficient' => 1.5],
            ['label' => 'Canicule', 'coefficient' => 1.2],
            ['label' => 'Neige', 'coefficient' => 1.8],
            ['label' => 'Brouillard', 'coefficient' => 1.1],
            ['label' => 'Tempête', 'coefficient' => 2.0],
        ];

        foreach ($defaults as $contrainte) {
            self::firstOrCreate(
                ['label' => $contrainte['label']],
                [
                    'coefficient' => $contrainte['coefficient'],
                    'actif' => true
                ]
            );
        }
    }
}