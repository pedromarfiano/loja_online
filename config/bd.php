<?php
$data = ['localhost', 'root', '', 'dbloja'];
$db = new MySqli($data[0],$data[1],$data[2],$data[3]);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected";

?>