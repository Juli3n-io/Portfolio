<?php 

//récupération des skills
function getSkill(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM skills'
  );
  $skill = $req->fetchAll(PDO::FETCH_ASSOC);
  return $skill;
}

//vérification sur category existe déja
function getSkillBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM skills
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $skill =$req->fetch(PDO::FETCH_ASSOC);
     return $skill ?: null;
      }


  //count du nombre de post
function countSkill(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from skills");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de skills publié
function countSkillPublie(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from skills WHERE est_publie = 1");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de post publié
function countSkillNonPublie(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from skills WHERE est_publie = 0");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

?>