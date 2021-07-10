<?php
$servername = "sql113.epizy.com";
$username = "epiz_29082376";
$password = "QpMvoaE3ImzA";
$dbname = "epiz_29082376_myshopdbs";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>