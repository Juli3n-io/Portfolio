<?php

//récupération des link
function getLink(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM origin_clicks
       WHERE titre != "Bot" AND  titre != "Autres"
       ORDER BY nb_clicks DESC'
  );
  $link = $req->fetchAll(PDO::FETCH_ASSOC);
  return $link;
}

//vérification si langage existe déja
function getLinkBy(PDO $pdo, string $colonne, $valeur): ?array
  {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM origin_clicks
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $link =$req->fetch(PDO::FETCH_ASSOC);
     return $link ?: null;
  }

function getDayVisites(PDO $pdo){

  $date = date('Y-m-d');

  $data = $pdo->query("SELECT nb_visites FROM visites WHERE date = '$date'");
  $thisDay = $data->fetch(PDO::FETCH_ASSOC);

  if($thisDay){
    return $thisDay['nb_visites'];
  }else{
    return 0;
  }

}

function getMonth_Visites(PDO $pdo){
  

$data = $pdo->query("SELECT SUM(nb_visites)
                        FROM visites
                        WHERE MONTH(date) = MONTH(CURRENT_DATE())");
$visites = $data->fetch(PDO::FETCH_ASSOC);

if($visites['SUM(nb_visites)']){
  return $visites['SUM(nb_visites)'];
}else{
  return 0;
}

}

function getYear_Visites(PDO $pdo){
  

  $data = $pdo->query("SELECT SUM(nb_visites)
                          FROM visites
                          WHERE YEAR(date) = YEAR(CURRENT_DATE())");
  $visites = $data->fetch(PDO::FETCH_ASSOC);
  
  if($visites['SUM(nb_visites)']){
    return $visites['SUM(nb_visites)'];
  }else{
    return 0;
  }
  
  }

function getTotales_Visites(PDO $pdo){

  $data = $pdo->query("SELECT SUM(nb_visites) FROM visites");
  $visites = $data->fetch(PDO::FETCH_ASSOC);

    if($visites['SUM(nb_visites)']){
      return $visites['SUM(nb_visites)'];
    }else{
      return 0;
    }
  }

function getBestLink(PDO $pdo){

  $req=$pdo->query(
    'SELECT *
      FROM origin_clicks
      WHERE titre != "Bot" AND  titre != "Autres"
      ORDER BY nb_clicks DESC
      LIMIT 1'
 );
 $link = $req->fetchAll(PDO::FETCH_ASSOC);
 return $link;

    
}

//récupération des bots
function getBot(PDO $pdo)
{
$req=$pdo->query(
  'SELECT *
    FROM origin_clicks
    WHERE titre = "Bot"');
  $botvisites = $req->fetch(PDO::FETCH_ASSOC);
  return $botvisites['nb_clicks'];
}


?>
