// get date
const date =  new Date();
document.querySelector(".date").innerHTML = new Date().getFullYear();

var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);

//gestion des images pour safari ancienne version
function browserDetect() {
  
  if (isSafari) {
    //hero
    let heroImg = document.getElementsByClassName('img-fluid')[0];
    heroImg.setAttribute("src", "assets/img/hero.png");

    //about
    let aboutImg = document.getElementById('about-img');
    aboutImg.style.backgroundImage = 'url("assets/img/profil.jpeg")';

    //modal contact backgroundImage
      let msgModal = document.getElementById('modal-msg')
      if(msgModal != undefined) {
        msgModal.style.backgroundImage = 'url("assets/img/contact-modal-illustration.png")';
      }
    
    //cookie
    let cookieImg = document.getElementsByClassName('cookie-img')[0];
      if(cookieImg) {
      cookieImg.setAttribute("src", "assets/img/cookie.png");
      }

  }
  
}
browserDetect()

$(document).ready(function(){
  

  // menu header
  $(".sidemenu-toggler").click(function(){  
    $('.sidemenu').addClass('active');
  });

  $('.close').click(function(){
    $('.sidemenu').removeClass('active');
  })

  $('#menu li a').click(function(){
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
  
// nombre de click des posts
  $(document).on('click', '.post-link', function(e) {
    e.preventDefault();
    var post_id = this.getAttribute('data-id');

    $.ajax({
      url: "assets/scripts/posts_clicks_script.php",
      method: "post",
      data: { post_id: post_id },
      success: function (data) {
        
      }
    })
  
  })

//Mission freelance ouverture modal
  $(document).on('click', '.open-msg-modal', function (e) {
  
  e.preventDefault();
  var subject = $(this).attr("value"); 
  
  $.ajax({  
       url:"assets/scripts/modal_msg.php",  
       method:"post",  
       data:{subject:subject},  
       success:function(data){  
            $('#msg_detail').html(data);  
         $('#msgmodal').modal('show');
         browserDetect()
       }  
  });  
});  

//envoi de message des modals
$(document).on('submit','#contact-form-modal', function(e){  
  
  e.preventDefault();
  browserDetect()
  
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
       
        $('#contact-form-modal').trigger("reset");
        $('#notif').html(data.notif);
        $('#msgmodal').modal('hide');
                                  
      }else{
          
        $('#notif').html(data.notif); 

      } 

    }
  }); 
});  

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
$(document).on('submit','#formulaire-contact', function(e){  
  console.log('test formulaire')
  
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
       
        $('#notif').html(data.notif);
        $('#formulaire-contact').trigger("reset");
        
                                  
      }else{
          
        $('#notif').html(data.notif); 

      } 

    }
  }); 
});  



  
});

window.onload = function(){
  $('.hero-text').addClass('fade-in')
      $('.hero-img').addClass('fade-in')
}

new fullpage('#fullpage', {
  licenseKey: '56D1CF10-FB234396-B4B3342D-25E59CD7',
  menu: '#menu',
  anchors: ['home','about', 'services','skills', 'portfolio','pricing','experience','contact'],
  autoScrolling: true,
  scrollOverflow: true,
  css3: true,
  resize: false,
  navigation: true,
  navigationPosition: 'right',
  navigationTooltips: ['Home', 'A Propos', 'Mes Services','Compétences','Portfolio','Tarifs','Expériences & Formations', 'Contact'],
  normalScrollElements: '#exeTxt, #eduTxt',
  onLeave: (origin, destination, direction) => {
    const section = destination.item;

    if(destination.index === 0){

      $('.hero-text').addClass('fade-in')
      $('.hero-img').addClass('fade-in')
  
      }else{

        $('.hero-text').removeClass('fade-in')
        $('.hero-img').removeClass('fade-in')
      }

    if(destination.index === 1){

      $('.about').addClass('fade-in')
  
      }else{

        $('.about').removeClass('fade-in')
      }

    if(destination.index === 2){

      $('.services').addClass('fade-in')
  
    }else{

      $('.services').removeClass('fade-in')
      
    }
      

    if(destination.index === 3){

      $('.skills .heading').addClass('fade-in')
      $('.pro-skill').addClass('fade-in')
      $('.tech-skill').addClass('fade-in')
      $('.candidatos .parcial .pourcentagem').addClass('progress')

      $('.card').each(function(){

        $(this,'.bar').circleProgress({
      
          value : $(this).data("value")/100,
          startAngle: -1.55,
          size: 100,
          duration: 1500,
          fill : {gradient:[["#FF8C00", 0.15], ["#774BBB", 0.74] ]}
      
         })  
      
        })

    }else{
      
      $('.skills .heading').removeClass('fade-in')
      $('.pro-skill').removeClass('fade-in')
      $('.tech-skill').removeClass('fade-in')
      $('.candidatos .parcial .pourcentagem').removeClass('progress')

    }

    if(destination.index === 4){

    $('.portfolio').addClass('fade-in')
  
    }else{

      $('.portfolio').removeClass('fade-in')
      
    }

    if(destination.index === 5){

      $('.pricing').addClass('fade-in')
  
    }else{

      $('.pricing').removeClass('fade-in')
    
    }

    if(destination.index === 6){

      $('.experience h3').addClass('fade-in')
      $('.experience .education-item').addClass('fade-in')
      $('.experience .work-item').addClass('fade-in')

    }else{

      $('.experience h3').removeClass('fade-in')
      $('.experience .education-item').removeClass('fade-in')
      $('.experience .work-item').removeClass('fade-in')
    }

    if(destination.index === 7){



      $('.contact').addClass('fade-in')

      const contactTitle = document.querySelector('.contact .contact-info h4');


      new Typewriter(contactTitle,{
        loop: false,
        deleteSpeed: 20 // vitesse de suppresion des caractéres
      })
      .changeDelay(30)
      .typeString('Et si nous restions en contact ?') // text
      .pauseFor(1500) // pause entre 2 écriture
      .start()
      

    }else{

      $('.contact').removeClass('fade-in')
      
    }

  }
})



// animation Hero
const textAnim = document.querySelector('.designation');

new Typewriter(textAnim,{
  loop: true,
  deleteSpeed: 20 // vitesse de suppresion des caractéres
})
.changeDelay(30)
.typeString('Intégrateur <span class="web">WEB</span>') // text
.pauseFor(1500) // pause entre 2 écriture
.deleteChars(15)
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


