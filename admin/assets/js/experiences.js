$(document).ready(function () {

  /*
   * --> Add Expérience
   * 
   * # Ouverture du Modal d'ajout
   * 
   * ## Gestion de l"oublie du nom 
   * Désactivation du BTN si le champs du nom est manquant
   * 
   * ### gestion jquery ui de la date
   * 
   * #### retrait fin sur actual est coché
   * 
   * ##### traitement Ajax de l'ajout
   */
  
  // # modal d'ajout categorie
  $('#add_exe_modal').on('click', function () {
  
    $('#addmodal').modal('show');
  
  });
  
  
  // ## Gestion de l"oublie du nom
  $('#add_name_exe').blur(function(){
  
    if( $(this).val().length === 0 ) {
  
      $('#addExeBtn').prop("disabled", true).addClass('disabledBtn').removeClass('addBtn');
             
    }else{
  
      $('#addExeBtn').prop("disabled", false).removeClass('disabledBtn').addClass('addBtn');
  
    }
  
  });

  // ### gestion jquery ui de la date
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
        numberOfMonths: 1,
        showButtonPanel: true
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

  // #### retrait fin sur actual est coché
  $('#actuel').on('click', function () {
    if ($(this).is(':checked')) {
  
      $('.fin').fadeToggle("slow", "linear")
  
    }else{

      $('.fin').fadeToggle("slow", "linear")

    }
  });

  
  // ##### ajout expérience ajax
    $("#add_exe").on('submit', function(e){
  
      e.preventDefault();
  
      $.ajax({
  
        type: 'POST',
        url: 'assets/scripts/experiences/add_experience_script.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
  
          if(data.status == true){    


            $('#add_exe').trigger("reset");
            $('#notif').html(data.notif);
            $('#addmodal').modal('hide');
            $('#exe_table').hide().html(data.resultat).fadeIn();
                                      
          }else{


            $('#notif').html(data.notif); 
  
          } 
  
        }
      });
    });


    /*
 * --> Delete expérience
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
$('#delete_exe').on('submit', function(e){

  e.preventDefault();
  delete_exe();

  function delete_exe(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/experiences/delete_experience_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_exe').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#exe_table').hide().html(data.resultat).fadeIn();
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});


/*
 * --> Update experience
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## traitement Ajax de la modification
 */


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var exe_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/experiences/update_modal.php",  
       method:"post",  
       data:{exe_id:exe_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  



// ### update experiences ajax
$(document).on('submit', '#update_edu', function(e){
    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/experiences/update_experience_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    

          $('#update_exe').trigger("reset"); 
          $('#notif').html(data.notif);
          $('#editmodal').modal('hide');
          $('#exe_table').hide().html(data.resultat).fadeIn();

        }else{
          
          $('#notif').html(data.notif); 

        } 

      }
    });


});

/*
 * --> View experience
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var exe_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/experiences/view_experience_script.php",  
       method:"post",  
       data:{exe_id:exe_id},  
       success:function(data){  
            $('#exe_detail').html(data);  
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
    
    $.post('assets/scripts/experiences/est_publie_update_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#notif').html(data.notif);
                $('#exe_table').html(data.resultat); 
                
            }else{
             
                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});



});