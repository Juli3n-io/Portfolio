<?php

//récupération des posts
function getDocs(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM docs'
  );
  $docs = $req->fetchAll(PDO::FETCH_ASSOC);
  return $docs;
}


?>