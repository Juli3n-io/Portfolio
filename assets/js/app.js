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


  
  

//portfolio
$(window).on("load", function(){
  var  $container = $('.portfolioContainer');
  $container.isotope({

    filter:'*',
    animationOptions:{
      queue : true

    }

});

$('.portfolio-nav li').on('click', function(){

    $('.portfolio-nav .current').removeClass('current');
    $(this).addClass('current')
    var selector = $(this).attr('data-filter');
    $container.isotope({
      filter : selector,
      animationOptions: {
        queue : true
      }
    });
    return false
  });


});

// Portfolio function ajax pour nombre de click
$(document).on('click', '.post-link', function(){
  var post_id = $(this).data("id")

  $.ajax({  
    url:"assets/scripts/posts_clicks_script.php",  
    method:"post",  
    data:{post_id:post_id},
    success:function(data){  
     
    }  
    
  });   

})

// CV function ajax pour nombre de click
$(document).on('click', '.download-btn a', function(){

  var doc_id = this.id
  
  $.ajax({  
    url:"assets/scripts/cv_clicks_script.php",  
    method:"post",  
    data:{doc_id:doc_id},
    success:function(data){  
     
    }  
    
  });   

})

//education ouverture modal
$(document).on('click','.link-education', function(e){  
  e.preventDefault();
  var edu_id = $(this).attr("id");  
  
  $.ajax({  
       url:"assets/scripts/view_education_modal.php",  
       method:"post",  
       data:{edu_id:edu_id},  
       success:function(data){  
            $('#edu_detail').html(data);  
            $('#viewmodaledu').modal('show');  
       }  
  });  
});  

//experience ouverture modal
$(document).on('click','.link-experience', function(e){  
  e.preventDefault();
  var exe_id = $(this).attr("id"); 
  
  $.ajax({  
       url:"assets/scripts/view_experience_modal.php",  
       method:"post",  
       data:{exe_id:exe_id},  
       success:function(data){  
            $('#exe_detail').html(data);  
            $('#viewmodalexe').modal('show');  
       }  
  });  
});  

//envoi de message
$(document).on('submit','#contact-form', function(e){  
  e.preventDefault();
  
  $.ajax({

    type: 'POST',
    url: 'assets/scripts/send_message_script.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){   
       
        $('#contact-form').trigger("reset");
        $('#notif').html(data.notif);
                                  
      }else{
          
        $('#notif').html(data.notif); 

      } 

    }
  }); 
});  
  
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






// init controller
var controller = new ScrollMagic.Controller();

// animation about
const about = document.querySelector('.about');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: about
  })
  .setClassToggle('.about', 'fade-in')
  .addTo(controller)

// animation service
const servicesTitle = document.querySelector('.services .heading');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: servicesTitle
})
  .setClassToggle('.services .heading', 'fade-in')
  .addTo(controller)

const servicesItem = document.querySelector('.services .services-items');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: servicesItem
})
  .setClassToggle('.services .services-items', 'fade-in')
  .addTo(controller)

// animation tarif
const priceTitle = document.querySelector('.pricing .heading');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: priceTitle
})
  .setClassToggle('.pricing .heading', 'fade-in')
  .addTo(controller)

const priceItem = document.querySelector('.pricing .pricing-item');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: priceItem
  })
    .setClassToggle('.pricing .pricing-item', 'fade-in')
    .addTo(controller)

// animation skills
const skillsTitle = document.querySelector('.skills .heading')
var myContactScene = new ScrollMagic.Scene({
  triggerElement: skillsTitle
})
.setClassToggle('.heading', 'fade-in')
.addTo(controller)  

const techSkill = document.querySelector('.tech-skill');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: techSkill
})
  .setClassToggle('.tech-skill', 'fade-in')
  .addTo(controller) 

const pourcentagem = document.querySelector('.candidatos .parcial .pourcentagem')
var myContactScene = new ScrollMagic.Scene({
  triggerElement: pourcentagem
})
.setClassToggle('.candidatos .parcial .pourcentagem', 'progress')
.addTo(controller)  


const proSkill = document.querySelector('.pro-skill');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: proSkill
})
  .setClassToggle('.pro-skill', 'fade-in')
  .on('enter', function(e){
    // soft skill circle progress
    $('.card').each(function(){

    $(this,'.bar').circleProgress({

      value : $(this).data("value")/100,
      startAngle: -1.55,
      size: 100,
      duration: 1500,
      fill : {gradient:[["#FF8C00", 0.15], ["#774BBB", 0.74] ]}

     })  

    })

  })
  .addTo(controller)  


// animation portfolio
const portfolio = document.querySelector('.portfolio');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: portfolio
})
  .setClassToggle('.portfolio', 'fade-in')
  .addTo(controller)


// animation experience
const experienceH3 = document.querySelector('.experience h3');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: experienceH3
})
  .setClassToggle('.experience h3', 'fade-in')
  .addTo(controller)

const eduItem = document.querySelector('.education-item');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: eduItem
})
  .setClassToggle('.education-item', 'fade-in')
  .addTo(controller)

const workItem = document.querySelector('.work-item');
var myContactScene = new ScrollMagic.Scene({
  triggerElement: workItem
})
  .setClassToggle('.work-item', 'fade-in')
  .addTo(controller)


// contact contact
const contactTitle = document.querySelector('.contact .contact-info h4');

var myContactScene = new ScrollMagic.Scene({
triggerElement: contactTitle
})
.setClassToggle('.contact', 'fade-in')
.on("enter", function(e){
  new Typewriter(contactTitle,{
    loop: false,
    deleteSpeed: 20 // vitesse de suppresion des caractéres
  })
  .changeDelay(30)
  .typeString('Et si nous restions en contact ?') // text
  .pauseFor(1500) // pause entre 2 écriture
  .start()
})
.addTo(controller)
