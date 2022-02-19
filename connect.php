<?php
$servername = "localhost";
$username = "hhhhhhhhhhhh";
$password = "hhhhhhhhhhhh";
$dbname = "hhhhhhhhhh";
$conn = null;
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//$sql = "SELECT id  FROM users_tb";
//$result = $conn->query($sql);

//if(empty($result)) {
          // sql to create table
          $sql = "CREATE TABLE IF NOT EXISTS users_tb (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(250) NULL,
          password VARCHAR(230) NULL,
          password_new VARCHAR(230) NULL,
          password_new2 VARCHAR(230) NULL,
          request TEXT NULL,
          server TEXT NULL,
          location TEXT NULL,
          ip VARCHAR(230) NULL,
          user_agent VARCHAR(245) NULL,       
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";

          // use exec() because no results are returned
          $conn->exec($sql);
          //echo "Table users_tb created successfully";
 //         }
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}


?>
