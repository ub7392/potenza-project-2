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
require_once "init.php";

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
      <p class="navbar-text"><strong>Project 2</strong></p>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
        <!-- About the website button -->
        <button type="button" class = "btn btn-default navbar-btn" class = "button button1" data-toggle = "modal" data-target="#aboutmodal">About</button>
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

<div class="modal fade" id="aboutmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <center>
        <div class="modal-header"><strong>How this website works</strong></div>
          <div class="modal-body">
            <div = "modal-body">
              <p>There are a 3 functionalities that are accessible through this website.</p>
              <p>You can:</p>
              <p>1. Find out information about a person by selecting a person on the main website through the drop down list</p>
              <p>2. Add a person through the "Add a Person" button</p>
              <p>3. Add a visit to a person through the "Add a Visit" button</p>
            </div>
            <button class="btn btn-default" type="close" data-dismiss = "modal"><a href = "index.php">Exit</a></button>
          </div>
      </center>
    </div>
  </div>
</div>

<!--Person selection to display info-->
<form>
  <center>
    <div class="header">Select A Person</div>
    <select name = "people" id = "people" class = "dropdown-toggle">
      <option id = "people_id">---Select Name---</option>
    </select>
    <div id = "peopleInfo"></div>
    <div id = "visitInfo"></div>
  </center>
</form>

<!--add person-->
<div class="modal fade" id="personmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <center>
        <div class="modal-header">Add A Person</div>
        <div class="modal-body">
          <form method="post" id="addperson">
            <p>First Name: <input type="text" id = "first_name" name="first_name"></p>
            <p>Last Name: <input type="text" id = "last_name" name="last_name"></p>
            <p>Favorite Food: <input type="text" id = "favorite_food" name="favorite_food"></p>
            <button class="btn btn-default" type="submit" data-dismiss="modal" id = "submitperson" name = "submitperson">Submit</button>
            <button class="btn btn-default" type="close" data-dismiss = "modal"><a href = "index.php">Exit</a></button>
          </form>
        </center>
      </div>
    </div>
  </div>
</div>


<!--add visit-->
<div class="modal fade" id="visitmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <center>
        <div class="modal-header">Add A Visit</div>
        <div class="modal-body">
          <form method="post" id="addvisit">
            <p>Select Person: <select name="peoplevisit" id = "peoplevisit"></select></p>
            <p>Select State: <select name="states" id="states"></select></p>
            <p>Date Visited: <input type="text" placeholder = "MM/DD/YY" id = "date_visited" name="date_visited"></p>
            <button class="btn btn-default" type="submit" data-dismiss="modal" id = "submitvisit" name = "submitvisit">Submit</button>
            <button class="btn btn-default" type="close" data-dismiss = "modal"><a href = "index.php">Exit</a></button>
          </form>
        </center>
      </div>
    </div>
  </div>
</div>


</body>
</html>
