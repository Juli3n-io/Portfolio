<?php
require_once __DIR__ . './../../global/config/bootstrap.php';
require_once __DIR__ . './../functions/notifications.php';


$result = array();


if (!empty($_POST)) {

  $note = '';

  if (!empty($_POST['st1'])) {
    $note = 5;
  } elseif (!empty($_POST['st2'])) {
    $note = 4;
  } elseif (!empty($_POST['st3'])) {
    $note = 3;
  } elseif (!empty($_POST['st4'])) {
    $note = 2;
  } elseif (!empty($_POST['st5'])) {
    $note = 1;
  } else {
    $note = 0;
  }

  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $company = htmlspecialchars($_POST['company'], ENT_QUOTES, 'UTF-8');
  $contenu = htmlspecialchars($_POST['contenu'], ENT_QUOTES, 'UTF-8');
  $logo = NULL;
  $url = '';

  if (empty($name)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque votre nom');
  } elseif (empty($company)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque le nom de votre entreprise');
  } elseif (empty($contenu)) {

    $result['status'] = false;
    $result['notif'] = notif('warning', 'oups! il manque votre avis');
  } else {

    if (!$_FILES['add_logo']) {

      //insertion de l'image
      $extension = pathinfo($_FILES['add_logo']['name'], PATHINFO_EXTENSION);
      $path = __DIR__ . '/../../global/uploads';
      // Allow certain file formats 
      $allowTypes = array('svg', 'jpg', 'png', 'jpeg', 'webp');

      if ($_FILES['add_logo']['error'] !== UPLOAD_ERR_OK) {

        $result['status'] = false;
        $result['notif'] = notif('warning', 'Probléme lors de l\'envoi du fichier.code ' . $_FILES['add_logo']['error']);
      } elseif ($_FILES['add_logo']['size'] < 12 || !in_array($extension, $allowTypes)) {

        $result['status'] = false;
        $result['notif'] = notif('error', 'Le fichier envoyé n\'est pas une image');
      } else {

        do {
          $filename = bin2hex(random_bytes(16));
          $complete_path = $path . '/' . $filename . '.' . $extension;
        } while (file_exists($complete_path));
      }

      if (!move_uploaded_file($_FILES['add_logo']['tmp_name'], $complete_path)) {

        $result['status'] = false;
        $result['notif'] = notif('error', 'La photo n\'a pas pu être enregistrée');
      } else {


        $req1 = $pdo->prepare('INSERT INTO reviews_logo(logo) VALUES (:logo)');

        $req1->bindValue(':logo', $filename . '.' . $extension);
        $req1->execute();
      }

      $logo = $pdo->lastInsertId();
    }

    $req2 = $pdo->prepare('INSERT INTO reviews(name,
                                              company, 
                                              contenu,
                                              note,
                                              logo_id,
                                              url, 
                                              date_enregistrement,
                                              est_publie) 
                                    VALUES (:name,
                                            :company,
                                            :contenu, 
                                            :note,
                                            :logo,
                                            :url, 
                                            :date,
                                            :publie)');

    $req2->bindParam(':name', $name);
    $req2->bindParam(':company', $company);
    $req2->bindParam(':contenu', $contenu);
    $req2->bindParam(':note', $note);
    $req2->bindValue(':logo', $logo);
    $req2->bindParam(':url', $url);
    $req2->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));
    $req2->bindValue(':publie', 0);
    $req2->execute();




    $result['status'] = true;
    $result['notif'] = notif('success', 'Merci pour votre avis');
  }
}

// Return result 
echo json_encode($result);
