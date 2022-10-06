<?php

  session_start();

  require_once 'functions.php';

  if(isset($_POST['submit']))
  { 
    $registerFlag = true;

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    if(checkIfLoginHasBadChars($login) == false){
      $registerFlag = false;
      $_SESSION['loginError'] = "Login can only consists of letters and numbers";
    }
    if(checkIfAddressEmailIsCorrect($email) == false){
      $registerFlag = false;
      $_SESSION['emailError'] = "Enter correct email address";
    }

    if(checkIfPasswordIsCorrect($password) == false){
      $registerFlag = false;
      $_SESSION['passwordError'] = "Password must contain a number.";
    }

    if(checkIfNameIsCorrect($name) == false){
      $registerFlag = false;
      $_SESSION['nameError'] = "Name can only consists of letters.";
    }

    $_SESSION['fr_login'] = $login;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password'] = $password;
		$_SESSION['fr_name'] = $name;


    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($serverName,$dbUsername,$dbPassword,$dbName);

      if($connection->connect_errno !=0)
      {
        throw new Exception(mysqli_connect_errno());
      }
      else{
        $emailCommand = "SELECT id FROM users WHERE email = '$email'";
        $resultOfEmailCommand = $connection->query($emailCommand);

        if(!$resultOfEmailCommand) throw new Exception($connection->error);

        $numberOfEmails = $resultOfEmailCommand->num_rows;

        if($numberOfEmails > 0){
          $registerFlag = false;
          $_SESSION['emailError'] = "Email address already exists.";
        }

        $loginCommand = "SELECT id FROM users WHERE username = '$login'";
        $resultOfLoginCommand = $connection->query($loginCommand);
        if(!$resultOfLoginCommand) throw new Exception($connection->error);

        $numberOfUsernames = $resultOfLoginCommand->num_rows;
        if($numberOfUsernames > 0){
          $registerFlag = false;
          $_SESSION['loginError'] = "Username already exists.";
        }

        if($registerFlag){

          $passwordHash = password_hash($password, PASSWORD_DEFAULT);

          $insertUsernameCommand = "INSERT INTO users VALUES (NULL,'$login','$passwordHash','$email')";
          if($connection->query($insertUsernameCommand)){
            $_SESSION['registered'] = true;
            $_SESSION['welcomeMessage'] = 'User successfully registered';
            $getUserId = $connection->query("SELECT id FROM users WHERE username = '$login'");
            $resultOfGetUserId = $getUserId->fetch_assoc();
            $userId = $resultOfGetUserId['id'];
            $insertDefaultIncomesCommand = "INSERT INTO incomes_category_assigned_to_users SELECT NULL,'$userId',name FROM incomes_category_default";
            $insertDefaultExpensesCommand = "INSERT INTO expenses_category_assigned_to_users SELECT NULL,'$userId',name FROM expenses_category_default";
            $insertDefaultMethodsCommand = "INSERT INTO payment_methods_assigned_to_users SELECT NULL,'$userId',name FROM payment_methods_default";
            
            $connection->query($insertDefaultIncomesCommand);
            $connection->query($insertDefaultExpensesCommand);
            $connection->query($insertDefaultMethodsCommand);
            
            }
            else{
                throw new Exception($connection->error);
              }
        }
        $connection->close();
      }
    }
    catch(Exception $e)
    {
      echo '<span style="color:red;">Server Error. Try again later!</span>';
    }
  }
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">
  <link rel="stylesheet" href="css/bootstrap.css">



</head>

<body>

  <main>
    <section class="main-section">
      <div class="container">
        <div class="row text-center justify-content-center align-items-center">
          <div class="col-12 col-md-6 ">
            <div class="left-side-wrap">
              <header>
                <div class="logo">
                  <h1>E-WALLET</h1>
                </div>
                <h5>Simple way to manage personal finances.</h5>
                <h5>Track your expenses and incomes.</h5>
                <h5>View period time summaries.</h5>
              </header>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form">
              <form action="register.php" method="post" class="p-4 bg-white rounded" style="max-width: 70%;">
                <div class="row text-center justify-content-center align-items-center">
                  <div class="col-10 my-2">
                    <input type="text" class="form-control" name="login" placeholder="Enter login" minlength="5" maxlength="20" required>
                    <?php
                    if(isset($_SESSION['loginError']))
                    {
                      echo '<div style = "color: red; margin: 0.5rem;font-size: 0.9rem;">'.$_SESSION['loginError'].'</div>';
                      unset($_SESSION['loginError']);
                    }
                    ?>
                  </div>
                  <div class="col-10 my-2">
                    <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                    <?php
                    if(isset($_SESSION['emailError']))
                    {
                      echo '<div style = "color: red; margin: 0.5rem;font-size: 0.9rem;">'.$_SESSION['emailError'].'</div>';
                      unset($_SESSION['emailError']);
                    }
                    ?>
                  </div>
                  <div class="col-10 my-2">
                    <div class="password-wrapper">
                      <input type="password" class="form-control" name="password" id = "password" placeholder="Enter password" minlength="6" maxlength="20" required>
                      <span><i id="toggler" class="icon-eye"></i>
                    </div>
                    <?php
                      if(isset($_SESSION['passwordError']))
                      {
                        echo '<div style = "color: red; margin: 0.5rem;font-size: 0.9rem;">'.$_SESSION['passwordError'].'</div>';
                        unset($_SESSION['passwordError']);
                      }
                    ?>
                  </div>
                  <div class="col-10 my-2">
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                    <?php
                    if(isset($_SESSION['nameError']))
                    {
                      echo '<div style = "color: red; margin: 0.5rem;font-size: 0.9rem;">'.$_SESSION['nameError'].'</div>';
                      unset($_SESSION['nameError']);
                    }
                    ?>
                  </div>
                  <div class="col-10">
                    <button type="submit" name="submit" class="col-12 btn btn-primary btn-block my-2">Register</button>
                    <?php
                    if(isset($_SESSION['welcomeMessage']))
                    {
                      echo '<div style = "color: green; margin: 0.5rem;font-size: 1rem;font-weight: bold;">'.$_SESSION['welcomeMessage'].'</div>';
                      unset($_SESSION['welcomeMessage']);
                      unset($_SESSION['registered']);
                    }
                    ?>
                  </div>
                  <p class="my-4 border-bottom">Already have an account?</p>
                  <div class="col-10">
                    <a href="login.php"><button type="button" class="col-10 btn btn-primary">Sign In</button></a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="row text-center m-0">
      <div class="col-12 col-md-3">
        <i class="icon-ok-circled2"></i>
        <h6>Manage finances</h6>
      </div>
      <div class="col-12 col-md-3">
        <i class="icon-ok-circled2"></i>
        <h6>Save money</h6>
      </div>
      <div class="col-12 col-md-3">
        <i class="icon-ok-circled2"></i>
        <h6>Track expenses</h6>
      </div>
      <div class="col-12 col-md-3">
        <i class="icon-ok-circled2"></i>
        <h6>Track incomes</h6>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

  <script src="js/script.js"></script>
</body>

</html>