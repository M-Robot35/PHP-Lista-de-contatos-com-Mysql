<?php

use sys4soft\Database;

// ===============================================
// Cria sessão para cada usuario  / Global - Header
// ==============================================
session_start();

require_once('libraries/Database.php');

// =======================================
// connexão com Bd
// =======================================
define('MYSQL_CONFIG', [
    "host"=>'localhost',
    "database"=>'php_pdo_contactos',
    "username"=>'thiago',
    "password"=>'tu7oR3t2',
]);

$connect= new Database(MYSQL_CONFIG);
