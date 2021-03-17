<?php

//récupération des posts
function getExe(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM experiences'
  );
  $exep= $req->fetchAll(PDO::FETCH_ASSOC);
  return $exep;
}

//vérification si existe déja
function getExeBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM experiences
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $exep =$req->fetch(PDO::FETCH_ASSOC);
     return $exep ?: null;
      }
?>