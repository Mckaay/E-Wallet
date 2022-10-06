<?php

	session_start();
	
	if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn']==true))
	{
		header("Location: main-menu.php");
		exit();
	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

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
              <form  action = "signIn.php"class="p-4 bg-white rounded" style="max-width: 70%;" method ="post">
                <div class="row text-center justify-content-center align-items-center">
                  <div class="col-10 my-2">
                    <input type="text" class="form-control" id="login" placeholder="Enter login" name = "login" required>
                  </div>
                  <div class="col-10 my-2">
                    <div class="password-wrapper">
                      <input type="password" class="form-control" id="password" name = "password" placeholder="Enter password" required >
                      <span><i id="toggler" class="icon-eye"></i>
                    </div>
                  </div>
                  <div class="col-10">
                    <button type="submit" name = "submit" class="col-12 btn btn-primary btn-block my-2">Log In</button>
                    <?php
                    if(isset($_SESSION['error']))
                    {
                      echo '<div style = "color: red; margin: 0.5rem;font-size: 0.9rem;">'.$_SESSION['error'].'</div>';
                      unset($_SESSION['error']);
                    }
                    ?>
                  </div>
                  <div class="col-10 my-3">
                    <button type="button" class="btn btn-link border-bottom"><a href="register.php">Forgot
                        password?</a></button>
                  </div>
                  <p class="my-2">Don't have an account?</p>
                  <div class="col-10">
                    <a href="register.php"><button type="button" class="col-10 btn btn-primary">Create
                        Account</button></a>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"
    crossorigin="anonymous"></script>


  <script src="js/script.js"></script>

</body>

</html>