$(document).ready(function (){

  /*
   * --> Add fichiers
   * 
   * # Ouverture du Modal d'ajout
   * 
   * ## traitement Ajax de l'ajout
   */
  
  // # modal d'ajout categorie
  $('#add_doc_btn').on('click', function () {
      $('#addmodal').modal('show');
  });
  
  
  
  // ## ajout doc ajax
  $("#add_doc").on('submit', function(e){

      e.preventDefault();
  
      $.ajax({
  
        type: 'POST',
        url: 'assets/scripts/docs/add_doc_script.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
  
          if(data.status == true){   
            
            $('#add_doc').trigger("reset");
            $('#notif').html(data.notif);
            $('#addmodal').modal('hide');
            $('#doc_table').html(data.resultat); 
                                      
          }else{
            
            $('#notif').html(data.notif); 
  
          } 
  
        }
      });
  });


  /*
 * --> Delete doc
 * 
 * # Ouverture du Modal de suppresion
 * 
 * ## Gestion de la confirmation de suppression
 * Désactivation du BTN si l'utilisateur n'a pas confirmé la suppression
 * 
 * ### traitement Ajax de la suppression
 */


// # modal delete langage
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

    $('#deletedoc').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deletedoc').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});


// ### delete cat ajax
$('#delete_doc').on('submit', function(e){


  e.preventDefault();
  delete_doc();

  function delete_doc(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+ id + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/docs/delete_doc_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_doc').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#doc_table').html(data.resultat); 
                $('#cards').html(data.cards); 
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});

/*
 * --> View doc
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var doc_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/docs/view_doc_script.php",  
       method:"post",  
       data:{doc_id:doc_id},  
       success:function(data){  
            $('#doc_detail').html(data);  
            $('#viewmodal').modal("show");  
       }  
  });  
});  
  
  
  
  });