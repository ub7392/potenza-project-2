$(document).ready(function(){
  peopleDropdown();
  stateDropdown();
  /*info();

  $("#addperson")[0].reset();
  $("#addvisit")[0].reset();

  $('#submitperson').on('click', function(e){
    e.preventDefault();
    addPeople();
    $("#addperson")[0].reset();
  });

  $('#submitvisit').on('click', function(e){
    e.preventDefault();
    addVisit();
    $("#addvisit")[0].reset();
  });*/
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
/*
function info(){
  $("#people").on("click", function(){
    var peopleid = $("#people").val();

    $.ajax({
      type: "GET",
      url: "api/visits/" + peopleid,
      dataType: "json",
      success: function(data){
        $("#peopleInfo").empty();
        $("#visitInfo").empty();

        var len = data.length;

        if(len > 0){
          var firstname = data[0]["firstname"];
          var lastname = data[0]["lastname"];
          var favoritefood = data[0]["favorite_food"];

          $("#peopleInfo").append("<p>Name: " +firstname+ " " +lastname+ "</p><p>Favorite Food: " +favoritefood+ "</p><p>State(s) Visited: ");

          for(var i = 0; i < len; i++){
            var state = data[i]["state_id"];
            var date = data[i]["date_visited"];

            $("#visitInfo").append(+state+ " on " +date+);
          }
        }else{
              var firstname = data[0]["firstname"];
              var lastname = data[0]["lastname"];
              var favoritefood = data[0]["favorite_food"];
              var len = data.length;
              $("#peopleInfo").append("<p>Name: " +firstname+ " " +lastname+ "</p><p>Favorite Food: " +favoritefood+ "</p><p>State(s) Visited: None");
            },
            error: function(data){
              console.log("There is an error loading info.")
            }
          });
        }
      },
      error: function(data){
        console.log("There is an error loading info.")
      }
    });
  });
}

function addPerson(){
  $.ajax({
    type: "POST",
    url: "api/people",
    data: $("#addperson").serialize(),
    dataType: "json",
    success: function(data){
      console.log(data);
      console.log($"#addperson").serialize());
      alert("Person successfully added!");
      peopleDropdown();
      //info();
    },
    error: function(data){
      alert("Error adding person!");
      console.log(data);
      console.log($("#addperson").serialize());
    }
  });
}

function addVisit()
{
	$.ajax({
		type: "POST",
		url: "api/visits",
		data: $("#addvisit").serialize(),
		dataType: "json",
		success: function(data)
		{
			console.log(data);
			console.log($("#addvisit").serialize());
			alert("Visit successfully added!");
		},
		error: function(data, status, xhr)
		{
			alert("Error: Please fill out all inputs");
			console.log(data);
			console.log(status);
			console.log(xhr);
			console.log($("#addvisit").serialize());
		}
	});
}*/
