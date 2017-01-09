<?php
$conn=mysql_connect('localhost', 'root', 'root', 'project2');
mysql_select_db('project2');

if(!$conn){
  die("Connection failed: ".$conn->error);
}

$requestURI = parse_url($_SERVER['REQUEST_URI']);
$segments = explode('/', $requestURI['path']);
$apiVars = [];

$i = 2;
while($i < count($segments)){
	if($segments[$i+1]) {
      $apiVars[$segments[$i]] = $segments[$i+1];
      $i += 2;
	} else {
      $apiVars[$segments[$i]] = 'null';
      $i++;
	}
}
//api/people
function getPeople($people_id){
  global $conn;
  $response = [];

  //api/people
  if($people_id === 'null'){
    $query = "SELECT * FROM people";

    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result))
    {
      $response[] = [
        'people_id' => $row['people_id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'favorite_food' => $row['favorite_food']
      ];
    }

    header('Content-Type: application/json');
    echo(json_encode($response));

  //api/people/#
  }elseif(is_numeric($people_id)){
    $query = "SELECT * FROM people WHERE people_id = ".$people_id;

    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result))
    {
      $response[] = [
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'favorite_food' => $row['favorite_food']
      ];
    }
    header('Content-Type: application/json');
    echo(json_encode($response));
    }
}

//api/states
function getStates($states_id){
  global $conn;
  $response = [];

  //api/states
  if($states_id === 'null'){
    $query = "SELECT * FROM states";

    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result))
    {
      $response[] = [
        'states_id' => $row['states_id'],
        'state_name' => $row['state_name'],
        'state_abbreviation' => $row['state_abbreviation']
      ];
    }

    header('Content-Type: application/json');
    echo(json_encode($response));
  //api/states/#
  }elseif (is_numeric($states_id)){
    $query = "SELECT * FROM states WHERE states_id = ".$states_id;

    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result))
    {
      $response[] = [
        'states_id' => $row['states_id'],
        'state_name' => $row['state_name'],
        'state_abbreviation' => $row['state_abbreviation']
      ];
    }
    header('Content-Type: application/json');
    echo(json_encode($response));
  }
}

//api/visits
function getVisits($visits_id){
  global $conn;
  $response = [];
  //api/visits
  if($visits_id === 'null'){
    $query = "SELECT * FROM visits";
    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result))
    {
      $response[] = [
        'person_id' => $row['person_id'],
        'state_id' => $row['state_id'],
        'date_visited' => $row['date_visited']
      ];
    }

    header('Content-Type: application/json');
    echo(json_encode($response));
  //api/visits/#
  }elseif (is_numeric($visits_id)){
    $query = "SELECT
              people.first_name,
              people.last_name,
              people.favorite_food,
              states.state_name,
              states.state_abbreviation,
              visits.date_visited
              FROM people
              INNER JOIN visits ON visits.person_id = people.people_id
              INNER JOIN states ON states.states_id = visits.state_id
              WHERE people.people_id = ".$visits_id;

    $result = mysql_query($query, $conn);
    while($row = mysql_fetch_array($result)){
      $response[] = [
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'favorite_food' => $row['favorite_food'],
        'state_name' => $row['state_name'],
        'state_abbreviation' => $row['state_abbreviation'],
        'date_visited' => $row['date_visited']
      ];
    }

    if(empty($response)){
      $query = "SELECT * FROM people
                WHERE people_id = ".$visits_id;

      $result = mysql_query($query, $conn);
      while($row = mysql_fetch_array($result)){
        $response[] = [
          'first_name' => $row['first_name'],
          'last_name' => $row['last_name'],
          'favorite_food' => $row['favorite_food'],
        ];
      }

          header('Content-Type: application/json');
          echo(json_encode($response));
    }else{

          header('Content-Type: application/json');
          echo(json_encode($response));
    }
  }
}

function addPeople(){
  global $conn;

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $favorite_food = $_POST['favorite_food'];

  $query = "INSERT INTO people
            (first_name, last_name, favorite_food)
            VALUES('$first_name', '$last_name', '$favorite_food')";

  if(mysql_query($query)){
    echo(json_encode(" ".$first_name." ".$last_name." was successfully added!"));
  }else{
    echo(json_encode(mysql_error()));
  }
}

function addVisit(){
  global $conn;

  $person_id = $_POST['peoplevisit'];
  $state_id = $_POST['states'];
  $date_visited = $_POST['date_visited'];

  $query = "INSERT INTO visits
            (person_id, state_id, date_visited)
            VALUES('$person_id', '$state_id', '$date_visited')";

  if(mysql_query($query)){
    echo(json_encode("This visit to was successfully added!"));
  }else{
    echo(mysql_error());
  }
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(isset($apiVars['people'])){
    getPeople($apiVars['people']);
  }elseif(isset($apiVars['states'])){
    getStates($apiVars['states']);
  }elseif(isset($apiVars['visits'])) {
    getVisits($apiVars['visits']);
  }
}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($apiVars['people'])){
    addPeople();
  }else if(isset($apiVars['visits'])){
    addVisit();
  }else{
    die(mysql_error());
  }
}else{
  die(mysql_error());
}

 mysql_close($conn);
?>
