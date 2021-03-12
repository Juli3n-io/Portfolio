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

  // soft skill circle progress
  let options = {
      startAngle: -1.55,
      size: 100,
      value : 0.85,
      fill : {gradient:[["#FF8C00", 0.15], ["#774BBB", 0.74] ]}
    }
    $('.circle .bar').circleProgress(options).on('circle-animation-progress', function(event,progress, stepValue){
      $(this).parent().find("span").text(String(stepValue.toFixed(2).substr(2)) + "%")
    });
  
    $('.team .bar').circleProgress({
      value : $('.team .box').data("value")/100,
    })
      
    $('.Communication .bar').circleProgress({
      value : $('.Communication .box').data("value")/100,
    })
  
    $('.projet .bar').circleProgress({
      value : $('.projet .box').data("value")/100,
    })
    $('.commercial .bar').circleProgress({
      value : $('.commercial .box').data("value")/100,
    })

  
});

// animation Hero
const textAnim = document.querySelector('.designation');

new Typewriter(textAnim,{
  loop: true,
  deleteSpeed: 20 // vitesse de suppresion des caractéres
})
.changeDelay(30)
.typeString('Développeur <span class="web">WEB</span>') // text
.pauseFor(1500) // pause entre 2 écriture
.deleteChars(3)
.typeString('<span style="color : #FC7B7B;">Front-end</span>')
.pauseFor(1500) // pause
.deleteChars(9) // nombre de caractére supprimé
.typeString('<span style="color : #1C73AA;">WordPress</span>')
.pauseFor(1500)
.deleteChars(9)
.typeString('<span style="color : #FCC989;">E-commerce</span>')
.pauseFor(1500)
.deleteChars(24)
.typeString('<span>Coffee <span style="color : #11643C">Lover <img class="coffee" src="assets/img/coffee.png"></span>')
.pauseFor(1500)
.start() 