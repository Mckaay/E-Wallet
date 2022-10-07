<?php

  session_start();


  if(!isset($_POST['submit'])){
    header("Location: index.php");
    exit();
  }

  require_once 'connect.php';
  mysqli_report(MYSQLI_REPORT_STRICT);

  try {
    $connection = new mysqli($serverName,$dbUsername,$dbPassword,$dbName);

    if($connection->connect_errno !=0) {
      throw new Exception(mysqli_connect_errno());
    }
    else {
      $login = $_POST['login'];
      $password= $_POST['password'];

      $login = htmlentities($login, ENT_QUOTES, "UTF-8");

      $result = $connection->query(
        sprintf("SELECT * FROM users WHERE username='%s'",
        mysqli_real_escape_string($connection,$login)));

      if (!$result)
        {
          throw new Exception($connection->error);
        }
      if($result->num_rows > 0){
         $record = $result->fetch_assoc();
         if(password_verify($password,$record['password']))
         {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = $record['id'];
            $_SESSION['username'] = $record['username'];
            $_SESSION['email'] = $record['email'];

            unset($_SESSION['error']);
            $result->free_result();
            header('Location: main-menu.php');
         }
         else {
            $_SESSION['error'] = "Wrong username or password!";
            header('Location: index.php');
         }
      }
      else {
        $_SESSION['error'] = "Wrong username or password!";
        header('Location: index.php');
      }
      $connection->close();
    }
  }
  catch(Exception $e)
  {
    $_SESSION['error'] ="Server error. Try again later!";
    echo "Server error. Try again later!";
  }

?>






