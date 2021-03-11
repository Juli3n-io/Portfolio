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
?>