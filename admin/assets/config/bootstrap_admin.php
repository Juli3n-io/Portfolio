<?php

 require_once __DIR__ .'/../../../global/config/bootstrap.php';

 require_once __DIR__ . '/../functions/auth.php';

 require_once __DIR__ . '/functions_global_admin.php';

 

if(!stripos($_SERVER['REQUEST_URI'], 'connexion') && !stripos($_SERVER['REQUEST_URI'], 'login_member.php')){
    $Membre = getMembre($pdo, $_GET['id_team_member'] ?? null);

    if($Membre === null){
        header('Location: connexion');
        exit();
        }
}