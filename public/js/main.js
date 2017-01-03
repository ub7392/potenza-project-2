$(document).ready(function(){
function selection(){

  $('.listpeople').append(function(){
    $.ajax({
      type: 'GET',
      url: 'api/people',
      dataType: 'json',
      success: function(response){
        var length = response.length;
        $('.listpeople').empty();
        for(var j=0; j<length; j++){
          var id = response[j]['people_id'];
          var firstname = response[j]['first_name'];
          var lastname = response[j]['last_name'];
          $('.listpeople').append("<option value='"+id+"' name='"+id+"' id='"+id+"'>"+firstname+ " "+lastname+"</option>");
        }
      },
      error: function(response){
        console.log('error');
      }
    });
  });

  $('.people_id').append(function(){
    $.ajax({
      type: 'GET',
      url: 'api/people',
      dataType: 'json',
      success: function(response){
        var length = response.length;
        $('.people_id_list_add').empty();
        for(var j=0; j<length; j++){
          var id = response[j]['people_id'];
          var firstname = response[j]['first_name'];
          var lastname = response[j]['last_name'];
          $('.people_id_list_add').append("<option value='"+id+"'' id='"+id+"'>"+firstname+ " "+lastname+"</option>");
        }
      },
      error: function(response){
        console.log('error');
      }
    });
  });
}

function displayHide(){
  $('#display_success').hide();
}

function displayShow(item){
  $('#display_success').show(function(){
  $('#display_success').empty().fadeIn().append("<div class='alert alert-success'><h6>A new "+item+" has been added</h6></div>").fadeOut(2000);
  });
}

function displayData(){
  var id = $('.listpeople').val();
  $.ajax({
    type: 'GET',
    url: 'api/visits/'+id,
    dataType: "json",
    success: function(response){
      $('.info').empty();
      $('.visits').empty();
      var length = response.length;
      if(length>0){
        var firstname = response[0]['first_name'];
        var lastname = response[0]['last_name'];
        var favoritefood = response[0]['favorite_food'];
        $('.info').append("<h6><code>"+firstname+" "+lastname+"</code>'s favorite food is <code>"+favoritefood+"</code></h6>");
        $('.visits').append("<table class='table table-bordered' id='table_visits'></table>");
        $('#table_visits').append("<tr><th>State(s) visited on</th></tr>")

        for(j=0; j<length; j++){
          var date = response[j]['date_visited'];
          var state = response[j]['state_name'];
          $('#table_visits').append("<tr><td><code>"+state+" "+date+"</code></td></tr>");
        }
      }else{
        $.ajax({
          type: 'GET',
          url: 'api/people/'+id,
          dataType: "json",
          success: function(response){
            $('.info').empty();
            $('.visits').empty();
            var firstname = response[0]['first_name'];
            var lastname = response[0]['last_name'];
            var favoritefood = response[0]['favorite_food'];
            $('.info').append("<h6><code>"+firstname+" "+lastname+"</code>'s favorite food is <code>"+favoritefood+"</code></h6>");
            $('.info').append("<h6><code>"+firstname+" "+lastname+"</code> has never traveled. </h6>");
          }
        });
      }
    }
  });
}

function displayStates(){
  $.ajax({
    type: 'GET',
    url: 'api/states',
    dataType: "json",
    success: function(response){
      var length = response.length;
      $('.state_id_list').empty();
      for(var j=0; j<length; j++ ){
        var stateid = response[j]['states_id'];
        var stateabb = response[j]['state_abbreviation'];
        var statename = response[j]['state_name'];
        $('.state_id_list').append("<option value='"+stateid+"'' name='"+stateid+"'>"+stateabb+ " - "+statename+"</option>");
      }
    }
});
}

selection();
displayHide();
displayData();

$('.listpeople').change(function(){
  displayData();
});

//Populate States
$('.state_id_list').append(function(){
  displayStates();
});

$('.addvisit_btn').click(function(event){
  event.preventDefault();

  $.ajax({
    type: 'POST',
    url: 'api/visits',
    data: $('.addvisit').serialize(),
    success: function(){
      selection();
      displayShow("visit");
      displayData();
    }
  });
});

$('.addperson_btn').click(function(event){
  event.preventDefault();

  $.ajax({
    type: 'POST',
    url: 'api/people',
    data: $('.addperson').serialize(),
    success: function(){
      selection();
      displayShow("person");
      displayData();
    }
  });
});
});
