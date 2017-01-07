$(document).ready(function(){
  peopleDropdown();
  stateDropdown();
  info();

  $("#addperson")[0].reset();
  $("#addvisit")[0].reset();

  $('#submitperson').on('click', function(e){
    e.preventDefault();
    addPerson();
    $("#addperson")[0].reset();
  });

  $('#submitvisit').on('click', function(e){
    e.preventDefault();
    addVisit();
    $("#addvisit")[0].reset();
  });
});

function peopleDropdown(){
  $.ajax({
    type: "GET",
    url: "api/people",
    dataType: "json",
    success: function(data){
      $("#people option").not("#people_id").remove();
      $("#peoplevisit option").remove();

      var len = data.length;
      for(var i = 0; i < len; i++){
        var id = data[i]["people_id"];
        var firstname = data[i]["first_name"];
        var lastname = data[i]["last_name"];
        $("#people").append("<option value='"+id+"'>"+firstname+ " "+lastname+"</option>");
        $("#peoplevisit").append("<option value='"+id+"'>"+firstname+ " "+lastname+"</option>");
      }
    },
    error: function(data){
      console.log("There is an error loading people.")
    }
  });
}

function stateDropdown(){
  $.ajax({
    type: "GET",
    url: "api/states",
    dataType: "json",
    success: function(data){
      $("#states option").remove();

      var len = data.length;
      for(var i = 0; i < len; i++){
        var id = data[i]["states_id"];
        var statename = data[i]["state_name"];
        var stateabb = data[i]["state_abbreviation"];
        $("#states").append("<option value='"+id+"'>"+statename+ " - "+stateabb+"</option>");
      }
    },
    error: function(data){
      console.log("There is an error loading states")
    }
  });
}

function info(){
  $("#people").change(function(){
    var peopleid = $("#people").val();

    $("#peopleInfo").empty();
    $("#visitInfo").empty();

    $.ajax({
      type: "GET",
      url: "api/visits/" + peopleid,
      dataType: "json",
      success: function(data){
        var len = data.length;

        if(len > 0){
          var firstname = data[0]["first_name"];
          var lastname = data[0]["last_name"];
          var favoritefood = data[0]["favorite_food"];

          $("#peopleInfo").append("<p></p><p>Name: " +firstname+ " " +lastname+ "</p><p>Favorite Food: " +favoritefood+ "</p><p>State(s) Visited: </p>");


          for(var i = 0; i < len; i++){
            var state = data[i]["state_name"];
            var stateabb = data[i]["state_abbreviation"];
            var date = data[i]["date_visited"];

            if(jQuery.isEmptyObject(state)){
              $("#visitInfo").append("No visits were recorded");
            }else{
              $("#visitInfo").append(" "+state+ " - " +stateabb+ " on " +date+ "</p>");
            }
          }
        }
      },
      error: function(data){
        console.log(data);
      }
    });
  });
}



function addPerson(){
  var firstname = document.getElementById("first_name").value;
  var lastname = document.getElementById("last_name").value;
  var favoritefood = document.getElementById("favorite_food").value;
//Check input Fields Should not be blanks.
  if (firstname == '' || lastname == '' || favoritefood == '') {
  alert("Please Fill All Fields!");
  }else{
    $.ajax({
      type: "POST",
      url: "api/people",
      data: $("#addperson").serialize(),
      dataType: "json",
      success: function(data){
      	console.log(data);
        alert(data);
        peopleDropdown();
      }
    });
  }
}

function addVisit()
{
  var date_visited = document.getElementById("date_visited").value;

  //Check input Fields Should not be blanks.
  if (date_visited == '') {
    alert("Please Fill All Fields!");
  }else{
	   $.ajax({
       type: "POST",
       url: "api/visits",
       data: $("#addvisit").serialize(),
       dataType: "json",
       success: function(data)
       {
         console.log(data);
         alert(data);
       }
     });
  }
}
