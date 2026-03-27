<?php

namespace controller\actions;

use model\Annonce;
use model\Categorie;
use Twig\Environment;

class search
{
    /**
     * Affiche la page de recherche
     */
    public function show(Environment $twig, array $menu, string $chemin, array $cat): void
    {
        $template = $twig->load("search.html.twig");

        $menu = [
            [
                'href' => $chemin,
                'text' => 'Acceuil'
            ],
            [
                'href' => $chemin . "/search",
                'text' => "Recherche"
            ]
        ];

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "categories" => $cat
        ]);
    }


    public function research(array $array, Environment $twig, array $menu, string $chemin, array $cat): void
    {
        $template = $twig->load("index.html.twig");

        $menu = [
            [
                'href' => $chemin,
                'text' => 'Acceuil'
            ],
            [
                'href' => $chemin . "/search",
                'text' => "Résultats de la recherche"
            ]
        ];

        $motclef    = str_replace(' ', '', $array['motclef'] ?? '');
        $codePostal = str_replace(' ', '', $array['codepostal'] ?? '');
        $categorie  = $array['categorie'] ?? '';
        $prixMin    = $array['prix-min'] ?? 'Min';
        $prixMax    = $array['prix-max'] ?? 'Max';

        $query = Annonce::query();

        if ($motclef !== "") {
            $query->where('description', 'like', '%' . $array['motclef'] . '%');
        }

        if ($codePostal !== "") {
            $query->where('ville', '=', $array['codepostal']); 
        }

        if ($categorie !== "Toutes catégories" && $categorie !== "-----" && $categorie !== "") {
            $categId = Categorie::find($categorie)?->id_categorie;
            if ($categId !== null) {
                $query->where('id_categorie', '=', $categId);
            }
        }

        if ($prixMin !== "Min" && is_numeric($prixMin)) {
            $query->where('prix', '>=', (float) $prixMin);
        }

        if ($prixMax !== "Max" && $prixMax !== "nolimit" && is_numeric($prixMax)) {
            $query->where('prix', '<=', (float) $prixMax);
        }

        $annonces = $query->get();

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonces"   => $annonces,
            "categories" => $cat
        ]);
    }
}