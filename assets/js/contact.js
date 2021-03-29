

$(document).ready(function(){

//envoi de message
$(document).on('submit','#formulaire-contact', function(e){  
  
  e.preventDefault();
  
  $.ajax({

    type: 'POST',
    url: 'assets/scripts/send_msg.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){   
       
        $('#formulaire-contact').trigger("reset");
        $('#notif').html(data.notif);
                                  
      }else{
          
        $('#notif').html(data.notif); 

      } 

    }
  }); 
});  


})
