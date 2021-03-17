<?php

//récupération des posts
function getDocs(PDO $pdo):array
{
  $req = $pdo->query(
     'SELECT *
       FROM docs
       ORDER BY date_enregistrement
       LIMIT 1'
  );
  $doc = $req->fetchAll(PDO::FETCH_ASSOC);
  return $doc;
}


//vérification si le doc est déjà dans le tableau
function getDocClick(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM cv_clicks
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $click =$req->fetch(PDO::FETCH_ASSOC);
     return $click ?: null;
      }
?>