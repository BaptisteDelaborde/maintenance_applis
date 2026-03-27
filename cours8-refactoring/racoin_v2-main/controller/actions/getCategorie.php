<?php

namespace controller\actions;

use model\Categorie;
use model\Annonce;
use model\Photo;
use model\Annonceur;
use Twig\Environment;

class getCategorie
{
    /** @var array */
    protected array $categories = [];

    /** @var array<Annonce> */
    protected array $annonce = [];


    public function getCategories(): array
    {
        return Categorie::orderBy('nom_categorie')->get()->toArray();
    }

    public function getCategorieContent(string $chemin, int|string $n): void
    {
        $tmp = Annonce::with("Annonceur")
            ->orderBy('id_annonce', 'desc')
            ->where('id_categorie', "=", $n)
            ->get();

        $annonce = [];

        foreach($tmp as $t) {
            $t->nb_photo = Photo::where("id_annonce", "=", $t->id_annonce)->count();

            $t->url_photo = ($t->nb_photo > 0)
                ? Photo::select("url_photo")->where("id_annonce", "=", $t->id_annonce)->first()?->url_photo ?? $chemin.'/img/noimg.png'
                : $chemin.'/img/noimg.png';

            $t->nom_annonceur = Annonceur::select("nom_annonceur")
                ->where("id_annonceur", "=", $t->id_annonceur)
                ->first()?->nom_annonceur;

            $annonce[] = $t;
        }

        $this->annonce = $annonce;
    }

    public function displayCategorie(Environment $twig, array $menu, string $chemin, array $cat, int|string $n): void
    {
        $template = $twig->load("index.html.twig");

        $nomCategorie = Categorie::find($n)?->nom_categorie ?? 'Catégorie inconnue';

        $menu = [
            [
                'href' => $chemin,
                'text' => 'Acceuil'
            ],
            [
                'href' => $chemin . "/cat/" . $n,
                'text' => $nomCategorie
            ]
        ];

        $this->getCategorieContent($chemin, $n);

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "categories" => $cat,
            "annonces"   => $this->annonce
        ]);
    }
}