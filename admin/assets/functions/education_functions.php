<?php

//récupération des posts
function getEdu(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM education'
  );
  $edu = $req->fetchAll(PDO::FETCH_ASSOC);
  return $edu;
}

//vérification si existe déja
function getEduBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM education
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $edu =$req->fetch(PDO::FETCH_ASSOC);
     return $edu ?: null;
      }
?>