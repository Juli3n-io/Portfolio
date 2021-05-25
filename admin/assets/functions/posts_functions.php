<?php

//récupération des posts
function getPost(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM posts'
  );
  $post = $req->fetchAll(PDO::FETCH_ASSOC);
  return $post;
}


//vérification si post existe déja
function getPostBy(PDO $pdo, string $colonne, $valeur): ?array
     {
       $req =$pdo->prepare(sprintf(
       'SELECT *
       FROM posts
       WHERE %s = :valeur',
       $colonne
       ));
    
     $req->bindParam(':valeur', $valeur);
     $req->execute();

     $post =$req->fetch(PDO::FETCH_ASSOC);
     return $post ?: null;
      }

//récupération des icones des categories
function getIcon(PDO $pdo, string $valeur) 

      {
        
        $id = $valeur;

          $query = $pdo->query("SELECT icone FROM categories WHERE id_categorie = '$id'");
          $cat = $query->fetch();
          
          return '<div class="img-logo"><i class="'.$cat['icone'].'"></i></div>';
      }

//count du nombre de post
function countPosts(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from posts");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de post publié
function countPostsPublie(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from posts WHERE est_publie = 1");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//count du nombre de post publié
function countPostsNonPublie(PDO $pdo) {
  $query = $pdo ->query("SELECT count(*) as nb from posts WHERE est_publie = 0");
  $data = $query->fetch();

  $count = $data['nb'];
  return $count;
}

//update cat -> récupération de l'ID'catégorie actuelle
function getActualCatID(PDO $pdo, INT $id){

  $req = $pdo->query(
    "SELECT id_categorie
    from categories
    WHERE id_categorie = '$id'");


    $cat = $req->fetch(PDO::FETCH_ASSOC);
    return $cat['id_categorie'];

  }

  //update cat -> récupération du titre'catégorie actuelle
function getActualCatTitle(PDO $pdo, INT $id){

  $req = $pdo->query(
    "SELECT titre_cat
    from categories
    WHERE id_categorie = '$id'");


    $cat = $req->fetch(PDO::FETCH_ASSOC);
    return $cat['titre'];

  }

  // update cat -> récupération des autres categories
function getOtherCat(PDO $pdo, INT $id)
{

  $req =$pdo->query(
    "SELECT *
    FROM categories
    WHERE id_categorie != '$id'"
    );

    $cat = $req->fetchAll(PDO::FETCH_ASSOC);
    return $cat;
     
}

//get click by post
function getClick(PDO $pdo, INT $id){

  $req = $pdo->query(
    "SELECT nb_clicks
    from clicks
    WHERE post_id = '$id'");


    $click = $req->fetch(PDO::FETCH_ASSOC);
    
    if($click){
      return $click['nb_clicks'];
    }else{
      return 0;
    }

  }



//Index récupération des posts par ordre de vue
function getPostIndex(PDO $pdo):array
{
  $query = $pdo->query("SELECT posts.*, clicks.*
                          FROM posts 
                          LEFT JOIN clicks on clicks.post_id = posts.id_post
                          ORDER BY nb_clicks DESC
                          LIMIT 5");
  $data = $query->fetchAll(PDO::FETCH_ASSOC);
  return $data;
}


//redimention des images
function redim($source, $width, $height, $quality){
    
  $imageSize = getimagesize($source);

  $imageRessource = imagecreatefromjpeg($source);

  $imageFinal = imagecreatetruecolor($width, $height);

  imagecopyresampled($imageFinal, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

  imagejpeg($imageFinal, $quality);
}
?>