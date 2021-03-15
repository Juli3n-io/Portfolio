<?php

//récupération des formations
function getEdu(PDO $pdo):array
{
  $req = $pdo->query(
     'SELECT *
       FROM education
       LIMIT 3'
  );
  $edu= $req->fetchAll(PDO::FETCH_ASSOC);
  return $edu;
}
?>