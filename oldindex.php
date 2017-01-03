<!DOCTYPE html>
<html>
<body>
<title>Project 2</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="css/main.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<?php
require "init.php";

$conn=mysql_connect('localhost', 'root', 'root', 'project2');
mysql_select_db('project2');

if(!$conn){
  die("Connection failed: ".$conn->error);
}
?>
<!-- navigation bar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Project 2</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
        <!-- About the website button -->
        <button type="button" class = "btn btn-default navbar-btn" data-toggle = "modal" data-target="#aboutmodal">About</button>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Add person button -->
        <button type="button" class = "btn btn-default navbar-btn" data-toggle = "modal" data-target="#personmodal">Add a Person</button>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Add visit button -->
        <button type="button" class = "btn btn-default navbar-btn" data-toggle = "modal" data-target = "#visitmodal"> Add a Visit</button>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- jumbotron about the website -->
<div id = "aboutmodal" class = "modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
      <div class = "modal-body">
        <div class="container-fluid">
          <div class="jumbotron jumbotron-fluid">
            <center><h1 class="display-text">How this website works</h1></center>
            <p>There are a 3 functionalities that are accessible through this website.</p>
            <p>You can:</p>
            <p>1. Find out information about a person by selecting a person on the main website through the drop down list</p>
            <p>2. Add a person through the "Add a Person" button</p>
            <p>3. Add a visit to a person through the "Add a Visit" button</p>
            <center><button data-dismiss = "modal"><a href = "index.php">Exit</a></button></center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#peopleid").on('submit', function(e){
    //as you have used hyperlink(a tag), this prevent to redirect to another/same page


    var id = $("#people").serialize();

    $.ajax({
      url: "api.php?people="+id,
      type: "GET",
      dataType: "application/json",
      data: {id: id},
      //type: should be same in server code, otherwise code will not run
      success: function(data){
        console.log(data);
      },
      error: function(xhr, resp, text){
        console.log(xhr, resp, text);
      }
      });
  });
});
</script>

<!-- Select person to find info about -->
<div><center> Find info on a Person </center>
  <form method = "GET" class = "peopleid">
    <center>
    <select name = "people">
    <option value = "">---Please select---</option>
    <?php
      $query = mysql_query("SELECT people_id, first_name, last_name FROM people");

      while($r = mysql_fetch_array($query)){
        echo '<option value = '.$r[people_id].'>'.$r['first_name']." ".$r['last_name'].'</option>';
      }
    ?>
    </select>
    <button class = "submit" type = "submit" data-dismiss = "modal"> Submit </button>
    </center>
  </form>
</div>
<?php
  $result = $_GET("people");
  echo $result;
 ?>

<!-- Add person form -->
<div id = "personmodal" class = "modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
      <div class = "modal-header"><center>Add a Person</center></div>
        <div class = "modal-body">
          <form method = "POST" class = "addperson">
            <center>
            <p>First Name:<input type:"text" name = "firstname"></p>
            <p>Last Name: <input type:"text" name = "lastname"></p>
            <p>Favorite Food: <input type:"text" name = "favoritefood"></p>
            <button class = "submit" type = "submit" data-dismiss = "modal"> Submit </button>
            <button data-dismiss = "modal"><a href = "index.php">Exit</a></button>
            </center>
          </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#addperson").on('submit', function(e){
    //as you have used hyperlink(a tag), this prevent to redirect to another/same page
    e.preventDefault();

    var firstname=$("#firstname").serialize();
    var lastname=$("#lastname").serialize();
    var favoritefood=$("#favoritefood").serialize();

    if(firstname==''||lastname==''||favoritefood=='')
    {
      alert("Please Fill All Fields");
    }

    $.ajax({
      url: "/api.php",
      type: "GET",
      dataType: "application/json",
      data: {firstname: "firstname",
             lastname: "lastname"
             favoritefood: "favoritefood"},
      //type: should be same in server code, otherwise code will not run
      success: function(data){
        //you can see the result from the console
        console.log(data.message);
      },
      error: function(xhr, resp, text){
        console.log(xhr, resp, text);
      }
      });
  });
});
</script>

<!-- Select visit form -->
<div id = "visitmodal" class = "modal fade">
  <div class = "modal-dialog">
    <div class = "modal-content">
      <div class = "modal-header"><center> Add a Visit </center></div>
        <div class = "modal-body">
          <form method = "POST" class = "addvisit">
            <center>
              <br>
              <select class = "person">
                <option value = "">---Please select a Person---</option>
                <?php
                  $query = mysql_query("SELECT people_id, first_name, last_name FROM people");

                  while($r = mysql_fetch_array($query)){
                  echo '<option value = '.$r[people_id].'>'.$r['first_name']." ".$r['last_name'].'</option>';
                  }
                ?>
              </select>
              </br>

              <br>
              <select name = "state">
                <option value = "">---Please select a state---</option>
                <?php
                $query1 = mysql_query("SELECT * FROM states");

                while($row=mysql_fetch_array($query1)){
                  echo '<option value='.$row[id].'>'.$row['state_name'].'</option>';
                }
                ?>
              </br>
              </select>

              <p></p>
              <br>Date Visited:</br><input type:"text" name = "datevisited"></br><p></p>
              <button class = "submit" type = "submit" data-dismiss = "modal"> Submit </button>
              <button data-dismiss = "modal"><a href = "index.php">Exit</a></button>
            </center>
          </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $("#addvisit").on('submit', function(e){
    //as you have used hyperlink(a tag), this prevent to redirect to another/same page
    e.preventDefault();

    var personid=$("#person").serialize();
    var stateid=$("#state").serialize();
    var datevisited=$("#datevisited").serialize();

    if(personid==''||stateid==''||datevisited=='')
    {
    alert("Please Fill All Fields");
    }


    $.ajax({
      url: "/api.php",
      type: "GET",
      dataType: "application/json",
      data: {personid: "personid",
             statid: "stateid"
             datevisited: "datevisited"},
      //type: should be same in server code, otherwise code will not run
      success: function(data){
        //you can see the result from the console
        console.log(data.message);
      },
      error: function(xhr, resp, text){
        console.log(xhr, resp, text);
      }
      });
  });
});
</script>
</body>
</html>
