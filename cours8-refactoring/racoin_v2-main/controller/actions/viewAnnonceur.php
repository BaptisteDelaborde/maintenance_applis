<?php

namespace controller\actions;

use model\Annonce;
use model\Annonceur;
use model\Photo;
use Twig\Environment;

class viewAnnonceur
{
    /** @var Annonceur|null */
    protected ?Annonceur $annonceur = null;

    public function afficherAnnonceur(Environment $twig, array $menu, string $chemin, int|string $n, array $cat): void
    {
        $this->annonceur = Annonceur::find($n);

        if ($this->annonceur === null) {
            echo "404";
            return;
        }

        $tmp = Annonce::where('id_annonceur', '=', $n)->get();

        $annonces = [];

        foreach ($tmp as $a) {
            $a->nb_photo = Photo::where('id_annonce', '=', $a->id_annonce)->count();

            $a->url_photo = ($a->nb_photo > 0)
                ? Photo::select('url_photo')->where('id_annonce', '=', $a->id_annonce)->first()?->url_photo ?? $chemin . '/img/noimg.png'
                : $chemin . '/img/noimg.png';

            $annonces[] = $a;
        }

        $template = $twig->load("annonceur.html.twig");

        echo $template->render([
            "nom"        => $this->annonceur,
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonces"   => $annonces,
            "categories" => $cat
        ]);
    }
}