<?php

namespace controller\actions;

use model\Departement;

class getDepartment {

    protected $departments = array();

    public function getAllDepartments() {
        return Departement::orderBy('nom_departement')->get()->toArray();
    }
}