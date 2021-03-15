<?php
// récupération des membres de la team
function getMember(PDO $pdo):array
{
  $req=$pdo->query(
     'SELECT *
       FROM team'
  );
  $memberTeam = $req->fetchAll(PDO::FETCH_ASSOC);
  return $memberTeam;
}


function notif(string $class, string $message){
$output = '<div class="notification">';
  $output .= '<div class="card '.$class.'">';
    $output .= '<div class="content">';
      $output .= '<div class="img"></div>';
      $output .= '<div class="details">';
        $output .= ' <span class="name">'.$class.'</span>';
        $output .= '<p>'.$message.'</p>';
      $output .= '</div>';
    $output .= '</div>';
    $output .= '<span class="close-btn">';
      $output .= '<i class="fas fa-times"></i>';
    $output .= ' </span>';
  $output .= '</div>';
$output .= '</div>';


  $output .= '<script>
  $(document).ready(function (){
      setTimeout(function(){
      $(".notification").addClass("hide");
      $(".notification").removeClass("show");
      },3000);
    $(".close-btn").click(function(){
      $(".notification").addClass("hide");
      $(".notification").removeClass("show"); 
    });
    setTimeout(function(){
      $(".notification").remove();
      },5000);
  })</script>';
      
  return $output;
}


// récupération des logos des categories | langages 
function getImg(PDO $pdo, INT $id)
{
  $data = $pdo->query("SELECT img FROM pics WHERE id_pics = '$id'");
  $photo = $data->fetch(PDO::FETCH_ASSOC);
  return $photo['img'];
}


function generateClass($string) {
  return preg_replace(array('/&.*;/','/\W/'),
              '-',
              preg_replace('/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig);/',
                       '',
                   htmlentities($string,ENT_NOQUOTES,'UTF-8')));
}