// get date
const date =  new Date();
document.querySelector(".date").innerHTML = new Date().getFullYear();
document.querySelector(".date2").innerHTML = new Date().getFullYear();


$(document).ready(function(){
  // menu header
  $(".sidemenu-toggler").click(function(){  
    $('.sidemenu').addClass('active');
  });

  $('.close').click(function(){
    $('.sidemenu').removeClass('active');
  })

  $(window).scroll(function(){
    var sc = $(window).scrollTop();
    if(sc > 0){
      $('.header').addClass('sticky');
    }else{
      $('.header').removeClass('sticky');
    }
  });

  
});