<?php
//OPEN CONNECTION
$conn=mysql_connect('localhost', 'root', 'root', 'project2');
mysql_select_db('project2');

if(!$conn){
  die("Connection failed: ".$conn->error);
}

$request = parse_url($_SERVER['REQUEST_URI']);
$path = explode('/', $request['path']);
$apiarray = [];
$j = 2;

while($j < count($path)) {
	if($path[$j+1]) {
  $apiarray[$path[$j]] = $path[$j+1];
  $j += 2;
	} else {
  $apiarray[$path[$j]] = null;
  $j++;
	}
}
header('Content-Type: application/json');
$requestMethod = $_SERVER["REQUEST_METHOD"];

//api/people
function getPeople(){
  global $conn;

  $query="SELECT * FROM people";

  $result=mysql_query($query, $conn);
  while($row=mysql_fetch_array($result))
  {
    $response[]=$row;
  }
  header('Content-Type: application/json');
  echo(json_encode($response));
}

function addperson(){
  global $conn;

  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $favoritefood = $_POST['favoritefood'];
  $query = "INSERT INTO people(people_id, first_name, last_name, favorite_food)
            VALUES (NULL, '$firstname', '$lastname', '$favoritefood')";
  if(mysql_query($query)){
    echo .$firstname. " " .$lastname. " was added";
  }else{
    die(mysql_error());
  }
}

function getPersonById($idFromRequest){
  global $conn;

  $query="SELECT * FROM people WHERE people_id = ".$idFromRequest;

	$result=mysql_query($query, $conn);
	while($row=mysql_fetch_array($result, true)){
		$response[]=$row;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

function getStates(){
  global $conn;

	$query="SELECT * FROM states";

	$result=mysql_query($query, $conn);

  while($row=mysql_fetch_array($result, true)){
		$response[]=$row;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

function getVisitById($idFromRequest){
  global $conn;

	$query="SELECT * FROM visits INNER JOIN people on visits.person_id = people.people_id INNER JOIN states on visits.state_id = states.states_id WHERE people_id =".$idFromRequest;

  if($requestId!= 0){
		$query=" WHERE people_id=".$requestId;
	}

  $response=array();
	$result=mysql_query($query, $conn);

  while($row=mysql_fetch_array($result, true)){
			$response[]=$row;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
function getVisits(){
  global $conn;

	$query="SELECT * FROM visits INNER JOIN people on visits.person_id = people.people_id INNER JOIN states on visits.state_id = states.states_id";
	$response=array();
	$result=mysql_query($query, $conn);

  while($row=mysql_fetch_array($result, true)){
		$response[]=$row;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

//api/visits
function addvisit(){
  global $conn;
	$personVisitId = $_POST['person-add'];
  $date = $_POST['date-vis'];
  $state = $_POST['state-vis'];
  $state_int = intval($state);
	$personVisitId_int = intval($personVisitId);
  $query = "INSERT INTO visits VALUES (DEFAULT, $personVisitId_int, $state_int, '$date')";

  if (mysql_query($conn, $query)){
    console.log("This visit was added");
  }else{
    die(mysql_error());
  }
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(array_key_exists('people', $apiarray)){
		if($apiarray['people'] == null){
			return 0;
		}elseif($apiarray['people'] !== null){
			getPersonById($apiarray['people']);
		}
  }elseif(array_key_exists('visits', $apiarray)){
		if($apiarray['visits'] == null){
			getVisits();
		}elseif($apiarray['visits'] !== null){
			getVisitById($apiarray['visits']);
		}else{
			return 0;
		}
	}elseif(array_key_exists('states', $apiarray)){
	   if($apiarray['states'] == null){
			getStates();
		  }else{
			     return 0;
		   }
      }else{
		      getPeople();
		        getStates();
		          getVisits();
	     }
}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(array_key_exists('people', $apiarray)){
    addperson();
	}elseif(array_key_exists('visits', $apiarray)){
		addvisit();
	}else{
		die(mysql_error());
	}
  }else{
		die(mysql_error());
  }

if(!result){
  die(mysql_error());
}

 mysql_close($conn);
?>
