<?php
session_start();

if (isset($_SESSION['loggedIn']) == false) {
  header("Location: index.php");
  exit();
}

if (isset($_POST['submit'])) {

  $amount = $_POST['amount'];
  $date = $_POST['date'];
  $category = $_POST['category'];
  $notes = $_POST['notes'];

  $notesWithoutSpace = str_replace(' ', '', $notes);

  $incomeValidationFlag = true;

  if (!ctype_alnum($notesWithoutSpace)) {
    if($notes == ''){}
    else{
    $expenseValidationFlag = false;
    $_SESSION['incomeNotesError'] = "Special characters in notes are not allowed!";
    }
  }
  if ($amount < 0) {
    $incomeValidationFlag = false;
    $_SESSION['incomeAmountError'] = "Amount must be greater than zero!";
  }

  require_once 'connect.php';


  try {

    if ($incomeValidationFlag) {
      $connection = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);

      if ($connection->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
      }

      $insertIncomeCommand = 'INSERT INTO incomes VALUES(NULL,' . $_SESSION['userId'] . ',' . $category . ',' . $amount . ',' . "'" . $date . "'" . ',' . "'" . $notes . "'" . ')';
      if ($connection->query($insertIncomeCommand)) {
        $_SESSION['incomeSuccess'] = "Income successfully added!";
      }
    }
  } catch (Exception $e) {
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
  <title>Add income</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-light py-3 border-bottom">
    <div class="container">
      <a class="navbar-brand" href="main-menu.php">E-WALLET</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="main-menu.php">Main Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="add-income.php">Add Income</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="add-expense.php">Add Expense</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view-balance-current.php">View Balance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">Settings</a>
          </li>
        </ul>
        <a href="logout.php"><button class="btn btn-outline-success " type="submit">Logout</button></a>
      </div>
    </div>
  </nav>



  <main>
    <div class="container">
      <h3 class="py-3 text-center">Add income</h3>
      <div class="form py-1">
        <form method="post" action="add-income.php" class="bg-white rounded form-add" style="max-width: 60%;">
          <div class="row row-add justify-content-center align-items-center text-center">
            <div class="col-12 col-sm-10  col-md-7 my-2">
              <label for="amount">Amount</label>
              <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" max="4294967295" step="0.01" min="0.01" required>
              <?php
              if (isset($_SESSION['incomeAmountError'])) {
                echo '<div style = "margin: auto; color: red;">' . $_SESSION['incomeAmountError'] . '</div';
                unset($_SESSION['incomeAmountError']);
              }
              ?>
            </div>
            <div class="col-12 col-sm-10  col-md-7 my-2">
              <label for="date">Date</label>
              <input type="date" class="form-control" name="date" id="date" min="2000-01-01" max="<?= date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-12 col-sm-10 col-md-7  my-2">
              <label for="category">Category</label>
              <select class="form-select" aria-label="Default select example" name="category" id="category" required>
                <?php
                require "functions.php";
                $sqlCommand = 'SELECT id,name FROM incomes_category_assigned_to_users WHERE user_id ='.$_SESSION['userId'];
                echo getCategories($sqlCommand);
                ?>
              </select>
            </div>
            <div class="col-12 col-sm-10  col-md-7 my-2">
              <label for="exampleFormControlTextarea1" class="form-label">Notes:</label>
              <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3"></textarea>
              <?php
              if (isset($_SESSION['incomeNotesError'])) {
                echo '<div style = "margin: auto; color: red;">' . $_SESSION['incomeNotesError'] . '</div';
                unset($_SESSION['incomeNotesError']);
              }
              ?>
            </div>
            <div class="row justify-content-center align-items-center">
              <div class="col-6 col-sm-6 col-md-3 my-4">
                <div class="d-grid gap-2">
                  <button class="btn btn-success btn-lg" name="submit" type="submit">Add</button>
                </div>
              </div>
              <div class="col-6 col-sm-6 col-md-3 my-4">
                <div class="d-grid gap-2">
                  <a href="main-menu.php"><button class="btn btn-danger btn-lg" type="button">Cancel</button></a>
                </div>
              </div>
              <?php
              if (isset($_SESSION['incomeSuccess'])) {
                echo '<div style = "margin: auto; color: green;font-weight: bold;">' . $_SESSION['incomeSuccess'] . '</div';
                unset($_SESSION['incomeSuccess']);
              }
              ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>