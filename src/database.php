<?php
$host = "ec2-54-83-201-84.compute-1.amazonaws.com";
$dbname = "d8dig4tas5he0b";
$user = "ngjqiltqlthopr";
$password = "17e666cbc1a4a2e21207ab0c36922a2a1463c91ea48e56557cb3272e1187439a";
$port = "5432";

$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;port=$port;password=$password";

$db = new PDO($dsn);

if($db){
  echo "Connected <br />".$db;
}else {
  echo "Not connected";
}
?>
