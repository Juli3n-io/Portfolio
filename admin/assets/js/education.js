$(document).ready(function () {

  /*
   * --> Add Education
   * 
   * # Ouverture du Modal d'ajout
   * 
   * ## Gestion de l"oublie du nom 
   * Désactivation du BTN si le champs du nom est manquant
   * 
   * ## gestion jquery ui de la date
   * #### traitement Ajax de l'ajout
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

  // ## gestion jquery ui de la date
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( ".from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  
  // ### ajout category ajax
    $("#add_edu").on('submit', function(e){
  
      e.preventDefault();
  
      $.ajax({
  
        type: 'POST',
        url: 'assets/scripts/education/add_education_script.php',
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
            $('#edu_table').hide().html(data.resultat).fadeIn();
                                      
          }else{

            
            
            $('#notif').html(data.notif); 
  
          } 
  
        }
      });
    });


    /*
 * --> Delete formation
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

    $('#deleteEdu').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deleteEdu').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});


// ### delete cat ajax
$('#delete_edu').on('submit', function(e){

  e.preventDefault();
  delete_cat();

  function delete_cat(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/education/delete_education_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_edu').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#edu_table').hide().html(data.resultat).fadeIn();
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});


/*
 * --> Update formation
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## traitement Ajax de la modification
 */


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var edu_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/education/update_modal.php",  
       method:"post",  
       data:{edu_id:edu_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  



// ### update formation ajax
$(document).on('submit', '#update_edu', function(e){
    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/education/update_education_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    

          $('#update_edu').trigger("reset"); 
          $('#notif').html(data.notif);
          $('#editmodal').modal('hide');
          $('#edu_table').hide().html(data.resultat).fadeIn();

        }else{
          
          $('#notif').html(data.notif); 

        } 

      }
    });


});

/*
 * --> View formation
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var edu_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/education/view_education_script.php",  
       method:"post",  
       data:{edu_id:edu_id},  
       success:function(data){  
            $('#edu_detail').html(data);  
            $('#viewmodal').modal("show");  
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
    
    $.post('assets/scripts/education/est_publie_update_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#notif').html(data.notif);
                $('#edu_table').html(data.resultat); 
                
            }else{
             
                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});



});