$(document).ready(function (){

  /*
   * --> Add skill
   * 
   * # Ouverture du Modal d'ajout
   * 
   * ## Gestion de l"oublie du titre 
   * Désactivation du BTN si le champs du nom est manquant
   * 
   * ### retour range %
   * 
   * #### traitement Ajax de l'ajout
   */
  
  // # modal d'ajout categorie
  $('#add_skill_btn').on('click', function () {
      $('#addmodal').modal('show');
  });
  
  // ## Gestion de l"oublie du nom
  $('#add_titre_skill').blur(function(){
  
      if( $(this).val().length === 0 ) {
    
        $('#addSkillBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
               
      }else{
    
        $('#addSkillBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');
    
      }
    
    });

    // ### retour range
  $(document).on('input', '#skillRange', function() {
    data = $(this).val();
    $('#rangeReturn').val(data + ' %');
});
  
  // #### ajout category ajax
  $("#add_skill").on('submit', function(e){
  
      e.preventDefault();
  
      $.ajax({
  
        type: 'POST',
        url: 'assets/scripts/skills/add_skill_script.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
  
          if(data.status == true){    
            
            $('#add_skill').trigger("reset");
            $('#notif').html(data.notif);
            $('#addmodal').modal('hide');
            $('#skills_table').html(data.resultat); 
            $('#cards').html(data.cards); 
                                      
          }else{
            
            $('#notif').html(data.notif); 
  
          } 
  
        }
      });
  });

  /*
 * --> View skill details
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var skill_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/skills/view_skill_script.php",  
       method:"post",  
       data:{skill_id:skill_id},  
       success:function(data){  
         
            $('#skill_detail').html(data);  
            $('#viewmodal').modal("show");  
       }  
  });  
});  
  

  /*
 * --> Delete skill
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

      $('#deleteskillbtn').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

    } else {

      $('#deleteskillbtn').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

    }
  });

  // ### delete langage ajax
  $('#delete_skill').on('submit', function(e){
    e.preventDefault();
    delete_cat();

    function delete_cat(){

      var id = $('#delete_id').val();
      var confirme = $('#confirmedelete').val();
      var parameters = "id="+id + '&confirmedelete=' + confirme;

        
      $.post('assets/scripts/skills/delete_skill_script.php', parameters, function(data){
        if(data.status == true){  

          $('#delete_skill').trigger("reset");
          $('#notif').html(data.notif);
          $('#deletemodal').modal('hide');
          $('#skills_table').hide().html(data.resultat).fadeIn(); 
          $('#cards').html(data.cards); 
                
        }else{

          $('#notif').html(data.notif); 

        } 
                
      }, 'json');
    }

  });
  
  /*
 * --> Update skill
 * 
 * # Ouverture du Modal d'edition
 * 
 * ### retour range update
 * 
 * ### traitement Ajax de la modification
 */


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var skill_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/skills/update_modal.php",  
       method:"post",  
       data:{skill_id:skill_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  


// ### retour range
$(document).on('input', '#UpdateskillRange', function() {
  data = $(this).val();
  $('#UpdaterangeReturn').val(data + ' %');
});

// ### update skill ajax
$(document).on('submit', '#update_skill', function(e){
    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/skills/update_skill_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    

          $('#update_skill').trigger("reset");
          $('#notif').html(data.notif);
          $('#editmodal').modal('hide');
          $('#skills_table').hide().html(data.resultat).fadeIn(); 
          $('#cards').html(data.cards); 

        }else{
        
          $('#notif').html(data.notif); 

        } 

      }
    });


});

/*
 * --> View all publiés
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#all_publie', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/skills/view_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#skills_table').html(data.resultat).fadeIn();  

       }  
  });  
});  
  
/*
 * --> View all non publiés
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#non_publie', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/skills/view_non_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#skills_table').html(data.resultat).fadeIn();  

       }  
  });  
});  


/*
 * --> View all post
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#all', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/skills/view_all.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#skills_table').html(data.resultat).fadeIn();  

       }  
  });  
});  


/*
 * --> Update est publie depuis le tableau
 * 
 * # traitement ajax de la publication a partir du tableau
 * 
 */

 // # traitement de la publication
 $(document).on('click', '.est_publie', function(e){
  e.preventDefault();

  $tr = $(this).closest('tr');
  
  let data = $tr.children('td').map(function () {

    return $(this).text()

  }).get();

  var publie = $(this).val();
  
  update_est_publie();

  function update_est_publie(){

    var id = data[0];
    var parameters = "id="+id + "&publie="+publie;

    
    $.post('assets/scripts/skills/est_publie_update_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#notif').html(data.notif);
                $('#skills_table').html(data.resultat); 
                $('#cards').html(data.cards); 
                
            }else{
             
                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});
  
  
});