$(document).ready(function () {

/*
 * --> Add Review
 * 
 * # Ouverture du Modal d'ajout
 * 
 * ## Gestion de l"oublie du nom 
 * Désactivation du BTN si le champs du nom est manquant
 * 
 * ### traitement Ajax de l'ajout
 */

// # modal d'ajout review
$('#add_review_modal').on('click', function () {
    $('#addmodalreview').modal('show');
});



// ### ajout post ajax
  $("#add_review").on('submit', function (e) {
  

    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/reviews/add_reviews_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    
          
          $('#add_review').trigger("reset");
          $('#notif').html(data.notif);
          $('#addmodalreview').modal('hide');
          $('#pagination-data').html(data.resultat); 
          $('#cards').html(data.cards); 
                                    
        }else{
          
          $('#notif').html(data.notif); 

        } 

      }
    });
  });
  

  /*
 * --> View Reviews
 * 
 * # Ouverture du Modal de vue
 *
 */

// # Ouverture du Modal de vue
$(document).on('click','.viewbtn', function(){  
  var reviews_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/reviews/view_reviews_script.php",  
       method:"post",  
       data:{reviews_id:reviews_id},  
       success:function(data){  
            $('#reviews_detail').html(data);  
            $('#viewmodal').modal("show");  
       }  
  });  
});
  
 /*
 * --> Delete reviews
 * 
 * # Ouverture du Modal de suppresion
 * 
 * ## Gestion de la confirmation de suppression
 * Désactivation du BTN si l'utilisateur n'a pas confirmé la suppression
 * 
 * ### traitement Ajax de la suppression
 */


// # modal delete education
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

    $('#deleteReviews').prop("disabled", false).removeClass('disabledBtn').addClass('deleteBtn');

  } else {

    $('#deleteReviews').prop("disabled", true).addClass('disabledBtn').removeClass('deleteBtn');

  }
});


// ### delete reviews ajax
$('#delete_reviews').on('submit', function(e){

  e.preventDefault();
  delete_cat();

  function delete_cat(){

    var id = $('#delete_id').val();
    var confirme = $('#confirmedelete').val();
    var parameters = "id="+id + '&confirmedelete=' + confirme;

        
    $.post('assets/scripts/reviews/delete_reviews_script.php', parameters, function(data){

            if(data.status == true){ 

                $('#delete_reviews').trigger("reset"); 
                $('#notif').html(data.notif);
                $('#deletemodal').modal('hide');
                $('#pagination-data').hide().html(data.resultat).fadeIn();
                
            }else{

                $('#notif').html(data.notif); 

            } 
                
    }, 'json');

}

});
  
  
/*
 * --> Update reviews
 * 
 * # Ouverture du Modal d'edition
 * 
 * ## traitement Ajax de la modification
 */


// # Ouverture du Modal de vue
$(document).on('click','.editbtn', function(){  
  var reviews_id = $(this).attr("id");  

  $.ajax({  
       url:"assets/scripts/reviews/update_modal.php",  
       method:"post",  
       data:{reviews_id:reviews_id},  
       success:function(data){  
            $('#update_modal').html(data);  
            $('#editmodal').modal("show");  
       }  
  });  
});  



// ### update reviews ajax
$(document).on('submit', '#update_reviews', function(e){
    e.preventDefault();

    $.ajax({

      type: 'POST',
      url: 'assets/scripts/reviews/update_reviews_script.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){

        if(data.status == true){    

          $('#update_reviews').trigger("reset"); 
          $('#notif').html(data.notif);
          $('#editmodal').modal('hide');
          $('#pagination-data').hide().html(data.resultat).fadeIn();

        }else{
          
          $('#notif').html(data.notif); 

        } 

      }
    });


});
  
/*
 * --> View all reviews
 * 
 * # traitement ajax
 * 
 */

$(document).on('click','#all', function(e){  
  e.preventDefault();

  $.ajax({  
       url:"assets/scripts/reviews/view_all.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#pagination-data').html(data.resultat);  

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
       url:"assets/scripts/reviews/view_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#pagination-data').html(data.resultat);  

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
       url:"assets/scripts/reviews/view_non_publie.php",  
       method:"post",
       dataType: 'json', 
       success:function(data){  

        $('#pagination-data').html(data.resultat);  

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
    url:"assets/scripts/reviews/pagination.php",
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