<?php

namespace App\Services;

use App\Models\ContrainteTemps;
use App\Models\Vehicule;

class PrixCalculator
{
    // Constante n utilisée dans les deux formules
    const N = 0.1;

    /**
     * Calcule le prix complet d'une commande.
     *
     * @param array $linges        Liste des linges avec leurs quantités
     *                             Format : [['prix' => int, 'quantite' => int], ...]
     * @param float $distanceMetres Distance de livraison en mètres
     * @param Vehicule $vehicule   Véhicule choisi pour la livraison
     *
     * @return array {
     *   detail:        array  — détail par linge,
     *   total_livraison: float,
     *   total_prestation: float,
     *   total_commande: float
     * }
     */
    public static function calculerCommande(
        array    $linges,
        float    $distanceMetres,
        Vehicule $vehicule
    ): array {
        // 1. Récupérer la somme des coefficients des contraintes temps ACTIVES
        $sommeCoefficientsContraintes = self::getSommeCoefficientsContraintes();

        // 2. Distance utilisée directement en mètres (pas de conversion)
        // 3. Calculer le détail pour chaque linge
        $detail = [];
        $totalLivraison  = 0;
        $totalPrestation = 0;

        foreach ($linges as $linge) {
            $resultat = self::calculerLinge(
                prixUnitaire:           $linge['prix'],
                quantite:               $linge['quantite'],
                distanceMetres:         $distanceMetres,
                coefficientVehicule:    (float) $vehicule->coefficient,
                sommeCoeffContraintes:  $sommeCoefficientsContraintes
            );

            $detail[]         = $resultat;
            $totalLivraison  += $resultat['prix_livraison'];
            $totalPrestation += $resultat['prix_prestation'];
        }

        return [
            'detail'            => $detail,
            'total_livraison'   => round($totalLivraison, 0),
            'total_prestation'  => round($totalPrestation, 0),
            'total_commande'    => round($totalLivraison + $totalPrestation, 0),
        ];
    }

    /**
     * Calcule les prix pour un linge spécifique.
     *
     * Formules :
     *   prix_livraison  = [(d × c_v) + (d × c_v × Σc_contraintes)] × (q × N)
     *                   = d × c_v × (1 + Σc_contraintes) × (q × N)
     *   où d est en mètres
     *
     *   prix_prestation = (p × q) - (p × q × N)
     *                   = p × q × (1 - N)
     *
     *   prix_total_linge = prix_livraison × 2 + prix_prestation
     */
    public static function calculerLinge(
        float $prixUnitaire,
        int   $quantite,
        float $distanceMetres,
        float $coefficientVehicule,
        float $sommeCoeffContraintes
    ): array {
        // ── Prix livraison ──────────────────────────────────────────────
        // Partie fixe :   d × c_v
        $partieFixe = $distanceMetres * $coefficientVehicule;

        // Partie contraintes : d × c_v × Σc_contraintes
        $partieContraintes = $distanceMetres * $coefficientVehicule * $sommeCoeffContraintes;

        // Facteur quantité : q × N
        $facteurQuantite = $quantite * self::N;

        $prixLivraison = (($partieFixe + $partieContraintes) * $facteurQuantite)*2;

        // ── Prix prestation ─────────────────────────────────────────────
        // p × q × (1 - N)
        $prixPrestation = $prixUnitaire * $quantite * (1 - self::N);

        // ── Prix total linge ────────────────────────────────────────────
        // Livraison × 2 (aller-retour) + prestation
        $prixTotalLinge = $prixLivraison  + $prixPrestation;

        return [
            'prix_livraison'    => round($prixLivraison, 2),
            'prix_prestation'   => round($prixPrestation, 2),
            'prix_total_linge'  => round($prixTotalLinge, 2),
            // Détail intermédiaire (utile pour le debug / la facture)
            'detail' => [
                'distance_metres'         => $distanceMetres,
                'coeff_vehicule'          => $coefficientVehicule,
                'somme_coeff_contraintes' => $sommeCoeffContraintes,
                'partie_fixe'             => round($partieFixe, 4),
                'partie_contraintes'      => round($partieContraintes, 4),
                'facteur_quantite'        => $facteurQuantite,
                'prix_unitaire'           => $prixUnitaire,
                'quantite'                => $quantite,
            ],
        ];
    }

    /**
     * Récupère la somme des coefficients des contraintes temps ACTIVES.
     * Résultat mis en cache statiquement pour éviter plusieurs requêtes
     * dans un même cycle de calcul.
     */
    private static ?float $cacheSommeContraintes = null;

    public static function getSommeCoefficientsContraintes(): float
    {
        if (self::$cacheSommeContraintes === null) {
            self::$cacheSommeContraintes = (float) ContrainteTemps::actif()
                ->sum('coefficient');
        }

        return self::$cacheSommeContraintes;
    }

    /**
     * Réinitialise le cache (utile dans les tests ou si les contraintes
     * changent en cours d'exécution).
     */
    public static function resetCache(): void
    {
        self::$cacheSommeContraintes = null;
    }
}