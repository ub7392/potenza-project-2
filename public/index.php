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
        <button type="button" class = "btn btn-default navbar-btn btn-warning" class = "button button1" data-toggle = "modal" data-target="#aboutmodal">About</button>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Add person button -->
        <button type="button" class = "btn btn-default navbar-btn btn-primary" data-toggle = "modal" data-target="#personmodal">Add a Person</button>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Add visit button -->
        <button type="button" class = "btn btn-default navbar-btn btn-info" data-toggle = "modal" data-target = "#visitmodal"> Add a Visit</button>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- jumbotron - about button for the website -->
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
            <center><button class="btn btn-default" type="close" data-dismiss = "modal"><a href = "index.php">Exit</a></button></center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <!--Person selection to display info-->
  <div id="info">
    <center>
      <div class="header">Select A Person</div>
      <select class="listpeople">
        <option class="people_id">---Select Name---</option>
      </select>
    </center>
    <div id="info_person">
      <div class="info">
      </div>
      <div class="visits">
      </div>
    </div>
  </div>

  <div id="display_success">
  </div>

  <div class="info_add">
  </div>

<!--add person-->
  <div class="modal fade" id="personmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <center>
          <div class="modal-header">Add A Person</div>
          <div class="modal-body">
            <form method="post" class="addperson">
              <p>First Name: <input type="text" name="firstname"></p>
              <p>Last Name: <input type="text" name="lastname"></p>
              <p>Favorite Food: <input type="text" name="favoritefood"></p>
              <button class="addperson_btn btn btn-default" type="submit" data-dismiss="modal">Submit</button>
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
            <form method="post" class="addvisit">
              <p>Select Person:<select class="listpeople_add" name="person-add"></select></p>
              <p>Select State:<select class="state_id_list" name="state-vis"></select></p>
              <p>Date Visited:<input type="text" placeholder = "MM/DD/YY" name="date-vis"></p>
              <button class="addvisit_btn btn btn-default" type="submit" data-dismiss="modal">Submit</button>
              <button class="btn btn-default" type="close" data-dismiss = "modal"><a href = "index.php">Exit</a></button>
            </form>
          </center>
        </div>
      </div>
    </div>
  </div>

  <div name="response">
  </div>

</div>

</body>
</html>
