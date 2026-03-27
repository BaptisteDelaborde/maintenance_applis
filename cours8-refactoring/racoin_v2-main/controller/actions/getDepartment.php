<?php

namespace controller\actions;

use model\Departement;

class getDepartment
{
    /** @var array */
    protected array $departments = [];

    /**
     * Récupère tous les départements sous forme de tableau
     */
    public function getAllDepartments(): array
    {
        return Departement::orderBy('nom_departement')->get()->toArray();
    }
}