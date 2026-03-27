<?php

require 'vendor/autoload.php';


use model\Annonceur;
use model\Photo;
use model\Annonce;
use Slim\Environment;

class index {
    /** @var array<Annonce> */
    protected array $annonce = [];

    public function displayAllAnnonce(Environment $twig, array $menu, string $chemin, array $cat): void {
        $template = $twig->load("index.html.twig");
        $menu = [['href' => $chemin, 'text' => 'Acceuil']];

        $this->getAll($chemin);
        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "categories" => $cat,
            "annonces"   => $this->annonce
        ]);
    }

    public function getAll(string $chemin): void {
        $tmp = Annonce::with("Annonceur")->orderBy('id_annonce', 'desc')->take(12)->get();

        foreach ($tmp as $t) {
            $t->nb_photo = Photo::where("id_annonce", "=", $t->id_annonce)->count();
            $t->url_photo = ($t->nb_photo > 0)
                ? Photo::select("url_photo")->where("id_annonce", "=", $t->id_annonce)->first()?->url_photo
                : '/img/noimg.png'; // Utilisation du Nullsafe operator ?->

            $t->nom_annonceur = Annonceur::select("nom_annonceur")
                ->where("id_annonceur", "=", $t->id_annonceur)
                ->first()?->nom_annonceur;
        }
        $this->annonce = $tmp->all();
    }

    public function displayException(Environment $twig, array $menu, string $chemin, array $cat): never {
        throw new \Exception('Cette méthode déclenche une exception.');
    }
}