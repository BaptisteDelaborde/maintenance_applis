<?php

namespace controller\actions;

use model\Annonce;
use model\Annonceur;
use Twig\Environment;

class addItem
{
    /**
     * Affiche le formulaire d'ajout
     */
    public function addItemView(Environment $twig, array $menu, string $chemin, array $cat, array $dpt): void
    {
        $template = $twig->load("add.html.twig");
        echo $template->render([
            "breadcrumb"   => $menu,
            "chemin"       => $chemin,
            "categories"   => $cat,
            "departements" => $dpt
        ]);
    }

    /**
     * Valide si une chaîne est un email valide
     */
    private function isEmail(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Traite l'ajout d'une nouvelle annonce
     */
    public function addNewItem(Environment $twig, array $menu, string $chemin, array $allPostVars): void
    {
        date_default_timezone_set('Europe/Paris');

        $nom              = trim($allPostVars['nom'] ?? '');
        $email            = trim($allPostVars['email'] ?? '');
        $phone            = trim($allPostVars['phone'] ?? '');
        $ville            = trim($allPostVars['ville'] ?? '');
        $departement      = trim($allPostVars['departement'] ?? '');
        $categorie        = trim($allPostVars['categorie'] ?? '');
        $title            = trim($allPostVars['title'] ?? '');
        $description      = trim($allPostVars['description'] ?? '');
        $price            = trim($allPostVars['price'] ?? '');
        $password         = trim($allPostVars['psw'] ?? '');
        $password_confirm = trim($allPostVars['confirm-psw'] ?? '');

        $errors = [];

        // Validation des champs
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
        if (empty($password) || $password !== $password_confirm) {
            $errors[] = 'Les mots de passe ne sont pas identiques';
        }

        if (!empty($errors)) {
            $template = $twig->load("add-error.html.twig");
            echo $template->render([
                "breadcrumb" => $menu,
                "chemin"     => $chemin,
                "errors"     => $errors
            ]);
        } else {
            $annonce   = new Annonce();
            $annonceur = new Annonceur();

            // Remplissage de l'annonceur
            $annonceur->email         = htmlentities($email);
            $annonceur->nom_annonceur = htmlentities($nom);
            $annonceur->telephone     = htmlentities($phone);

            // Remplissage de l'annonce
            $annonce->ville          = htmlentities($ville);
            $annonce->id_departement = (int) $departement;
            $annonce->prix           = (float) $price;
            $annonce->mdp            = password_hash($password, PASSWORD_DEFAULT);
            $annonce->titre          = htmlentities($title);
            $annonce->description    = htmlentities($description);
            $annonce->id_categorie   = (int) $categorie;
            $annonce->date           = date('Y-m-d');

            // Sauvegarde via Eloquent
            $annonceur->save();
            $annonceur->annonce()->save($annonce);

            $template = $twig->load("add-confirm.html.twig");
            echo $template->render(["breadcrumb" => $menu, "chemin" => $chemin]);
        }
    }
}