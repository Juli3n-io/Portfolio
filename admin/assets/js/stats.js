$(document).ready(function () {

  /*
* --> Add links
* 
* # Ouverture du Modal d'ajout
* 
* ## Gestion de l"oublie du nom 
* Désactivation du BTN si le champs du nom est manquant
* 
* ## retour range
* 
* #### traitement Ajax de l'ajout
*/

// # modal d'ajout categorie
$('#add_links_modal').on('click', function () {
  $('#addmodal').modal('show');
});




// #### ajout langage ajax
$("#add_link").on('submit', function(e){

  e.preventDefault();

  $.ajax({

    type: 'POST',
    url: 'assets/scripts/stats/add_link.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){    
        
        $('#add_link').trigger("reset");
        $('#notif').html(data.notif);
        $('#addmodal').modal('hide');
        $('#stats_table').hide().html(data.resultat).fadeIn(); 
                                  
      }else{
  
        $('#notif').html(data.notif); 

      } 

    }
  });
});


  /*
* --> Delete link
* 
* # Ouverture du Modal de suppresion
* 
* ## Gestion de la confirmation de suppression
* Désactivation du BTN si l'utilisateur n'a pas confirmé la suppression
* 
* ### traitement Ajax de la suppression
*/


// # modal delete link
$(document).on('click','.deletebtn', function () {
$('#deletemodal').modal('show');

$tr = $(this).closest('tr');

let data = $tr.children('td').map(function () {
          return $(this).text()
}).get();

$('#delete_id').val(data[0]);

});


// ## confirmation de la validation de suppression
$('#confirmedelete').on('click', function () {

  if ($(this).is(':checked')) {

    $('#deletelink').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deletelink').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});

// ### delete link ajax
$('#delete_link').on('submit', function(e){
  e.preventDefault();
  delete_cat();

  function delete_cat(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&confirmedelete=' + confirme;

      
    $.post('assets/scripts/stats/delete_link_script.php', parameters, function(data){
      if(data.status == true){  

        $('#delete_link').trigger("reset");
        $('#notif').html(data.notif);
        $('#deletemodal').modal('hide');
        $('#stats_table').hide().html(data.resultat).fadeIn(); 
              
      }else{

        $('#notif').html(data.notif); 

      } 
              
    }, 'json');
  }

});

/*
* --> Update link
* 
* # Ouverture du Modal d'edition
* 
* ## view logo if change
* 
* #### traitement Ajax de la modification
*/


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
var link_id = $(this).attr("id");  

$.ajax({  
     url:"assets/scripts/stats/update_modal.php",  
     method:"post",  
     data:{link_id:link_id},  
     success:function(data){  
          $('#update_modal').html(data);  
          $('#editmodal').modal("show");  
     }  
});  
});  

// ## changement de logo
$(document).on('click', '#changeIcone', function(e){
  
  $('#div_new_logo').toggleClass('dnone');
  $('.hiddenFileInput').toggleClass('plus').toggleClass('minus')
  
})


// ### update link ajax
$(document).on('submit', '#update_link', function(e){
  e.preventDefault();

  $.ajax({

    type: 'POST',
    url: 'assets/scripts/stats/update_link_script.php',
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){

      if(data.status == true){    

        $('#update_link').trigger("reset");
        $('#notif').html(data.notif);
        $('#editmodal').modal('hide');
        $('#stats_table').hide().html(data.resultat).fadeIn(); 
                                  
      }else{
      
        $('#notif').html(data.notif); 

      } 

    }
  });


});

/*
* --> View link
* 
* # Ouverture du Modal de vue
*
*/

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var link_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/stats/view_link_script.php",  
       method:"post",  
       data:{link_id:link_id},  
       success:function(data){  
            $('#link_detail').html(data);  
            $('#viewmodal').modal("show");  
       }  
  });  
});  


/*
* --> View data
*
*/
load_data();
function load_data(page){

  $.ajax({
    url:"assets/scripts/stats/pagination.php",
    method:"post",
    data:{page:page},
    success:function(data){
      $('#pagination-data').html(data);  
    }
  })

}

$(document).on('click', '.pagination_link', function(){
  var page = $(this).attr('id');
  load_data(page);
})

  
});

function copyUrl(url) {
  var copyText = url.value;

  console.log(copyText)

  copyText.select; 
  // copyText.setSelectionRange(0, 99999);

  document.execCommand("copy");
  alert("Url copiée: " + copyText);
}