<?php

//récupération des catégories
function getCat(PDO $pdo): array
{
  $req = $pdo->query(
    'SELECT *
       FROM categories'
  );
  $cat = $req->fetchAll(PDO::FETCH_ASSOC);
  return $cat;
}


// récupération des posts
function getPost(PDO $pdo)
{
  $query = $pdo->query("SELECT categories.*, posts.*, pics.*
                          FROM posts 
                          LEFT JOIN categories ON categories.id_categorie = posts.categories_id
                          LEFT JOIN pics on pics.id_pics = posts.pics_id
                          WHERE est_publie = 1
                          ORDER BY date_publication DESC
                          LIMIT 9");
  $data = $query->fetchAll(PDO::FETCH_ASSOC);
  return $data;
}

//vérification si le post est déjà dans le tableau
function getPostClick(PDO $pdo, string $colonne, $valeur): ?array
{
  $req = $pdo->prepare(sprintf(
    'SELECT *
       FROM clicks
       WHERE %s = :valeur',
    $colonne
  ));

  $req->bindParam(':valeur', $valeur);
  $req->execute();

  $click = $req->fetch(PDO::FETCH_ASSOC);
  return $click ?: null;
}
