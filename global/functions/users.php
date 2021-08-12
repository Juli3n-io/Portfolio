<?php
require_once __DIR__ . './../config/bootstrap.php';

//vérification si le jour existe déjà
function getVisites(PDO $pdo, string $colonne, $valeur): ?array
  {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM visites
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $visites =$req->fetch(PDO::FETCH_ASSOC);
     return $visites ?: null;
  }
