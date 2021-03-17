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

//récupération des experiences
function getExe(PDO $pdo):array
{
  $req = $pdo->query(
     'SELECT *
       FROM experiences
       LIMIT 3'
  );
  $exe= $req->fetchAll(PDO::FETCH_ASSOC);
  return $exe;
}
?>