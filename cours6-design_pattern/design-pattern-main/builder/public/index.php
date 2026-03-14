<?php
require('../vendor/autoload.php');

use App\MySQLQueryBuilder;

// Récuperer dans l'exemple du cours Builder

// Test 1 : SELECT * FROM table
$q1 = (new MySQLQueryBuilder())
    ->from('users')
    ->getQuery();
echo "1. " . $q1;

// Test 2 : SELECT colonnes FROM table WHERE ...
$q2 = (new MySQLQueryBuilder())
    ->select('id', 'name', 'email')
    ->from('users')
    ->where('id', '=', 1)
    ->getQuery();
echo "| TEST2. " . $q2;

// Test 3 : plusieurs WHERE (AND)
$q3 = (new MySQLQueryBuilder())
    ->select('id', 'name')
    ->from('users')
    ->where('id', '=', 1)
    ->where('name', '=', 'Burak')
    ->where('name', '=', 'Baptiste')
    ->getQuery();
echo "| TEST 3. " . $q3 ;