alert('test')

$(document).ready(function () {

  /*
   * --> Add Education
   * 
   * # Ouverture du Modal d'ajout
   * 
   * ## Gestion de l"oublie du nom 
   * Désactivation du BTN si le champs du nom est manquant
   * 
   * ### traitement Ajax de l'ajout
   */
  
  // # modal d'ajout categorie
  $('#add_edu_modal').on('click', function () {
  
    $('#addmodal').modal('show');
  
  });
  
  
  // ## Gestion de l"oublie du nom
  $('#add_name_edu').blur(function(){
  
    if( $(this).val().length === 0 ) {
  
      $('#addEduBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
             
    }else{
  
      $('#addEduBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');
  
    }
  
  });
  
  // ### ajout category ajax
    $("#add_edu").on('submit', function(e){
  
      e.preventDefault();
  
      $.ajax({
  
        type: 'POST',
        url: 'assets/scripts/categories/add_education_script.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
  
          if(data.status == true){    
           
            $('#add_edu').trigger("reset");
            $('#notif').html(data.notif);
            $('#addmodal').modal('hide');
            $('#edu_table').html(data.resultat); 
                                      
          }else{
              
            $('#notif').html(data.notif); 
  
          } 
  
        }
      });
    });



  });