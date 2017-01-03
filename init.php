<?php

$host='localhost';
$username='root';
$password='root';
$database='project2';

$conn=mysql_connect($host, $username, $password);

if(!$conn) {
    die("Connection failed: ".$conn->error);
}else{
    //echo("Connected successfully \n");
}

$createDB="CREATE DATABASE IF NOT EXISTS ".$database;
if(mysql_query($createDB))
{
  //echo("Database exists \n");
}else{
  echo ("CONNECTION FAILED ".$conn->error);
  die();
}

mysql_select_db($database);

$people="CREATE TABLE if not exists people
           (people_id  int NOT NULL PRIMARY KEY AUTO_INCREMENT,
            first_name  varchar(255),
            last_name  varchar(255),
            favorite_food  varchar(255)
            );";

         if(mysql_query($people)===TRUE)
          {
            //echo("People table created \n");
          }else{
            echo("Error creating people table: ".mysql_error());
            die();
          }

$states="CREATE TABLE if not exists states
           (states_id  int NOT NULL PRIMARY KEY AUTO_INCREMENT,
            state_name  varchar(255),
            state_abbreviation  varchar(255)
          )";

$addstates="INSERT INTO states
              (states_id, state_name, state_abbreviation)
              values(NULL, 'Louisiana', 'LA'),
                    (NULL, 'Texas', 'TX'),
                    (NULL, 'Alabama', 'AL'),
                    (NULL, 'Mississippi', 'MS'),
                    (NULL, 'Florida', 'FL'),
                    (NULL, 'California', 'CA'),
                    (NULL, 'New York', 'NY'),
                    (NULL, 'Colorado', 'CO'),
                    (NULL, 'Utah', 'UT'),
                    (NULL, 'Tennessee', 'TN')";

$result=mysql_query("SELECT * FROM states");

if(mysql_num_rows($result)==0){
  mysql_query($addstates);
}

if(mysql_query($states)===TRUE)
{
    //echo("States table with tables created \n");
}else{
  echo("Error creating states table: ".mysql_error());
}

$visits="CREATE TABLE if not exists visits
           (id  int NOT NULL PRIMARY KEY AUTO_INCREMENT,
            person_id  int,
            state_id  int,
            date_visited  varchar(255)
            );";

if(mysql_query($visits)===TRUE)
{
  //echo("Visits table created \n");
}else{
  echo("Error creating visits table: ".mysql_error());

}
?>
