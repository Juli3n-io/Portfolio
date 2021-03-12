<?php

//récupération des soft skills
function getSoftSkills(PDO $pdo):array
{
  $req = $pdo->query(
     'SELECT *
       FROM skills'
  );
  $SoftSkill = $req->fetchAll(PDO::FETCH_ASSOC);
  return $SoftSkill;
}


//récupération des tech skills
function gettechSkills(PDO $pdo):array
{
  $req = $pdo->query(
     'SELECT *
       FROM langages'
  );
  $TechSkill = $req->fetchAll(PDO::FETCH_ASSOC);
  return $TechSkill;
}



?>