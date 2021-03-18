<?php

function notif(string $class, string $message){
  $output = '<div class="notification">';
    $output .= '<div class="notif-card '.$class.'">';
      $output .= '<div class="notif-content">';
        $output .= '<div class="notif-img"></div>';
        $output .= '<div class="notif-details">';
          $output .= ' <span class="notif-name">'.$class.'</span>';
          $output .= '<p>'.$message.'</p>';
        $output .= '</div>';
      $output .= '</div>';
      $output .= '<span class="notif-close-btn">';
        $output .= '<i class="fas fa-times"></i>';
      $output .= ' </span>';
    $output .= '</div>';
  $output .= '</div>';
  
  
    $output .= '<script>
    $(document).ready(function (){
        setTimeout(function(){
        $(".notification").addClass("hide");
        $(".notification").removeClass("show");
        },5000);
      $(".notif-close-btn").click(function(){
        $(".notification").addClass("hide");
        $(".notification").removeClass("show"); 
      });
      setTimeout(function(){
        $(".notification").remove();
        },5000);
    })</script>';
        
    return $output;
  }
  
?>