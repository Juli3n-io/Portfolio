<?php

//récupération des sreviews
function getReviews(PDO $pdo): array
{
  $req = $pdo->query(
    'SELECT *
       FROM reviews
       WHERE est_publie = 1
       ORDER BY date_enregistrement DESC
      LIMIT 9'
  );
  $reviews = $req->fetchAll(PDO::FETCH_ASSOC);
  return $reviews;
}

// récupération des logos des categories | langages 
function getLogo(PDO $pdo, INT $id)
{
  $data = $pdo->query("SELECT * FROM reviews_logo WHERE id = '$id'");
  $photo = $data->fetch(PDO::FETCH_ASSOC);
  return $photo['logo'];
}
