<?php

namespace controller\actions;

use model\Annonce;
use model\Annonceur;
use model\Departement;
use model\Photo;
use model\Categorie;
use Twig\Environment;

class item
{
    /** @var Annonce|null */
    protected ?Annonce $annonce = null;

    /** @var Annonceur|null */
    protected ?Annonceur $annonceur = null;

    /** @var Departement|null */
    protected ?Departement $departement = null;

    /** @var mixed */
    protected mixed $photo = null;

    /** @var string|null */
    protected ?string $categItem = null;

    /** @var string|null */
    protected ?string $dptItem = null;

    public function __construct()
    {
    }

    public function afficherItem(Environment $twig, array $menu, string $chemin, int|string $n, array $cat): void
    {
        $this->annonce = Annonce::find($n);

        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $menu = [
            [
                'href' => $chemin,
                'text' => 'Acceuil'
            ],
            [
                'href' => $chemin . "/cat/" . $n,
                'text' => Categorie::find($this->annonce->id_categorie)?->nom_categorie ?? 'Inconnu'
            ],
            [
                'href' => $chemin . "/item/" . $n,
                'text' => $this->annonce->titre
            ]
        ];

        $this->annonceur   = Annonceur::find($this->annonce->id_annonceur);
        $this->departement = Departement::find($this->annonce->id_departement);
        $this->photo       = Photo::where('id_annonce', '=', $n)->get();

        $template = $twig->load("item.html.twig");

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonce"    => $this->annonce,
            "annonceur"  => $this->annonceur,
            "dep"        => $this->departement?->nom_departement,
            "photo"      => $this->photo,
            "categories" => $cat
        ]);
    }

    public function supprimerItemGet(Environment $twig, array $menu, string $chemin, int|string $n): void
    {
        $this->annonce = Annonce::find($n);

        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $template = $twig->load("delGet.html.twig");

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonce"    => $this->annonce
        ]);
    }

    public function supprimerItemPost(Environment $twig, array $menu, string $chemin, int|string $n, array $cat): void
    {
        $this->annonce = Annonce::find($n);

        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $reponse = false;
        $pass    = $_POST["pass"] ?? ''; // Coalescence nulle pour éviter le warning

        if ($pass !== '' && password_verify($pass, $this->annonce->mdp)) {
            $reponse = true;
            Photo::where('id_annonce', '=', $n)->delete(); // Utilisation d'une majuscule pour la classe Photo
            $this->annonce->delete();
        }

        $template = $twig->load("delPost.html.twig");

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonce"    => $this->annonce,
            "pass"       => $reponse,
            "categories" => $cat
        ]);
    }

    public function modifyGet(Environment $twig, array $menu, string $chemin, int|string $id): void
    {
        $this->annonce = Annonce::find($id);

        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $template = $twig->load("modifyGet.html.twig");

        echo $template->render([
            "breadcrumb" => $menu,
            "chemin"     => $chemin,
            "annonce"    => $this->annonce
        ]);
    }

    public function modifyPost(Environment $twig, array $menu, string $chemin, int|string $n, array $cat, array $dpt): void
    {
        $this->annonce = Annonce::find($n);

        if (!isset($this->annonce)) {
            echo "404";
            return;
        }

        $this->annonceur = Annonceur::find($this->annonce->id_annonceur);
        $this->categItem = Categorie::find($this->annonce->id_categorie)?->nom_categorie;
        $this->dptItem   = Departement::find($this->annonce->id_departement)?->nom_departement;

        $reponse = false;
        $pass    = $_POST["pass"] ?? '';

        if ($pass !== '' && password_verify($pass, $this->annonce->mdp)) {
            $reponse = true;
        }

        $template = $twig->load("modifyPost.html.twig");

        echo $template->render([
            "breadcrumb"   => $menu,
            "chemin"       => $chemin,
            "annonce"      => $this->annonce,
            "annonceur"    => $this->annonceur,
            "pass"         => $reponse,
            "categories"   => $cat,
            "departements" => $dpt,
            "dptItem"      => $this->dptItem,
            "categItem"    => $this->categItem
        ]);
    }

    private function isEmail(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function edit(Environment $twig, array $menu, string $chemin, array $allPostVars, int|string $id): void
    {
        date_default_timezone_set('Europe/Paris');

        // Récupération sécurisée via le tableau envoyé par Slim au lieu de $_POST
        $nom         = trim($allPostVars['nom'] ?? '');
        $email       = trim($allPostVars['email'] ?? '');
        $phone       = trim($allPostVars['phone'] ?? '');
        $ville       = trim($allPostVars['ville'] ?? '');
        $departement = trim($allPostVars['departement'] ?? '');
        $categorie   = trim($allPostVars['categorie'] ?? '');
        $title       = trim($allPostVars['title'] ?? '');
        $description = trim($allPostVars['description'] ?? '');
        $price       = trim($allPostVars['price'] ?? '');
        $password    = trim($allPostVars['psw'] ?? '');

        $errors = [];

        if (empty($nom)) {
            $errors[] = 'Veuillez entrer votre nom';
        }
        if (!$this->isEmail($email)) {
            $errors[] = 'Veuillez entrer une adresse mail correcte';
        }
        if (empty($phone) || !is_numeric($phone)) {
            $errors[] = 'Veuillez entrer votre numéro de téléphone';
        }
        if (empty($ville)) {
            $errors[] = 'Veuillez entrer votre ville';
        }
        if (!is_numeric($departement)) {
            $errors[] = 'Veuillez choisir un département';
        }
        if (!is_numeric($categorie)) {
            $errors[] = 'Veuillez choisir une catégorie';
        }
        if (empty($title)) {
            $errors[] = 'Veuillez entrer un titre';
        }
        if (empty($description)) {
            $errors[] = 'Veuillez entrer une description';
        }
        if (empty($price) || !is_numeric($price)) {
            $errors[] = 'Veuillez entrer un prix';
        }

        if (!empty($errors)) {
            $template = $twig->load("add-error.html.twig");
            echo $template->render([
                "breadcrumb" => $menu,
                "chemin"     => $chemin,
                "errors"     => $errors
            ]);
        } else {
            $this->annonce   = Annonce::find($id);
            $idannonceur     = $this->annonce->id_annonceur;
            $this->annonceur = Annonceur::find($idannonceur);

            $this->annonceur->email         = htmlentities($email);
            $this->annonceur->nom_annonceur = htmlentities($nom);
            $this->annonceur->telephone     = htmlentities($phone);

            $this->annonce->ville          = htmlentities($ville);
            $this->annonce->id_departement = (int) $departement;
            $this->annonce->prix           = (float) $price;
            $this->annonce->titre          = htmlentities($title);
            $this->annonce->description    = htmlentities($description);
            $this->annonce->id_categorie   = (int) $categorie;
            $this->annonce->date           = date('Y-m-d');

            // On ne met à jour le mot de passe que s'il a été renseigné
            if ($password !== '') {
                $this->annonce->mdp = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->annonceur->save();
            $this->annonceur->annonce()->save($this->annonce);

            $template = $twig->load("modif-confirm.html.twig");
            echo $template->render([
                "breadcrumb" => $menu,
                "chemin"     => $chemin
            ]);
        }
    }
}