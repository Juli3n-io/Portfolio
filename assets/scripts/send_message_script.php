<?php
require_once __DIR__ . './../functions/notifications.php';


$result = array(); 

if(!empty($_POST)){ 

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
$msg = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
$check = $_POST['valideCheck'];

if(!preg_match('~^[a-zA-Z_ ]+$~',$name)){

  $result['status'] = false;
  $result['notif'] = notif('info','oups! il manque votre nom'); 

}elseif(empty($email)){

  $result['status'] = false;
  $result['notif'] = notif('info','oups il manque votre email'); 

}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       
  $result['status'] = false;
  $result['notif'] = notif('warning','email non valide'); 

}elseif(empty($msg)){

  $result['status'] = false;
  $result['notif'] = notif('info','oups votre message est vide'); 

}elseif(!isset($check)){

  $result['status'] = false;
  $result['notif'] = notif('info','oups! il me faut votre autorisation pour vous contacter'); 

}else{

  $header ="MIME-Version: 1.0\r\n";
  $header.='From:"julien-quentier.fr"<postmaster@julien-quentier.fr>'."\n";
  $header.='Content-Type:text/html; charset="utf-8"'."\n";
  $header.='Content-Transfer-Encoding: 8bit';
  $message = '
                <html>
                <head>
                  <title>Un nouveau message - julien-quentier.fr</title>
                  <meta charset="utf-8" />
                </head>
                <body>
                  <font color="#303030";>
                    <div align="center">
                      <table width="600px">
                        <tr>
                          <td>
                            
                            <div align="center">Bonjour <b>Julien</b>,</div>
                            <br><br>
                            <div align="center">Vous avez reçu un nouveau message de : <b>'.$name.'</b></div>
                            <br><br>
                            <div align="center">Sujet : '.$subject.'</div>
                            <br><br>
                            <div align="center">Email de l\'expediteur : '.$email.'</div>
                            <br><br>
                            <div align="center">Message : '.$msg.'</div>
                            <br><br>

                          </td>
                        </tr>
                        
                      </table>
                    </div>
                  </font>
                </body>
                </html>
                ';
  mail("contact@julien-quentier.fr", $subject, $message, $header);

  $result['status'] = true;
  $result['notif'] = notif('success','Votre message a bien été envoyé');
   
}

}
// Return result 
echo json_encode($result);
?>