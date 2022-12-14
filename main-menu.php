<?php
    session_start();

    if(isset($_SESSION['loggedIn']) == false){
      header("Location: index.php");
      exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Menu</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-expand-lg py-4 border-bottom">
    <div class="container">
      <a class="navbar-brand" href="main-menu.html">E-WALLET</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
       <a href="logout.php"><button class="btn btn-outline-success" type="submit">Logout</button></a> 
    </div>
  </nav>

  <main>
    <div class="container">
      <div class="row text-center justify-content-center align-items-center my-4">
        <h3 class = "py-2">Main Menu</h3>
        <div class="col-10 my-2">
          <a href="add-income.php"><button class="col-8 col-md-4 btn btn-primary py-4 btn-main-menu" type="button">Add Income</button></a>
        </div>
        <div class="col-10 my-2">
          <a href="add-expense.php"><button class="col-8 col-md-4 btn btn-primary py-4 btn-main-menu" type="button">Add Expense</button></a>
        </div>
        <div class="col-10 my-2">
          <a href="view-balance-current.php"><button class="col-8 col-md-4 btn btn-primary py-4 btn-main-menu" type="button">View Balance</button></a>
        </div>
        <div class="col-10 my-2">
          <button class="col-8 col-md-4 btn btn-primary py-4 btn-main-menu" type="button">Settings</button>
        </div>
        <div class="col-10 my-2">
          <a href="logout.php"><button class="col-8 col-md-4 btn btn-primary py-4 btn-main-menu " type="button">Logout</button></a>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="row text-center m-5 py-5 justify-content-center">
      <div class="col-12 col-md-2">
        <i class="icon-ok-circled2"></i>
        <h6>Manage finances</h6>
      </div>
      <div class="col-12 col-md-2">
        <i class="icon-ok-circled2"></i>
        <h6>Save money</h6>
      </div>
      <div class="col-12 col-md-2">
        <i class="icon-ok-circled2"></i>
        <h6>Track expenses</h6>
      </div>
      <div class="col-12 col-md-2">
        <i class="icon-ok-circled2"></i>
        <h6>Track incomes</h6>
      </div>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>
</body>

</html>