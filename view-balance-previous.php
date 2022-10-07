<?php
session_start();

if (isset($_SESSION['loggedIn']) == false) {
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
  <title>View Balance</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fontello.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

  <div class="container">
    <div class="row justify-content-center align-items-center text-center border-bottom my-1">
      <div class="col-6 col-sm-6  col-md-2 my-2">
        <div class="dropdown">
          <button style="background-color: #009879;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
            Select Period
          </button>
          <div style="background-color: #f0f2f5;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a style="color: #1877f2;" class="dropdown-item" href="view-balance-current.php">Current Month</a>
            <a style="color: #1877f2;" class="dropdown-item" href="view-balance-previous.php">Previous Month</a>
            <button style="color: #1877f2;" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"> Define Period </button>
          </div>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Define Time Period:</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form style="box-shadow: none;" action="view-balance-custom.php" method="post">
                    <label for="firstDate">From: </label>
                    <input style="text-align: center; display: block;margin: auto;width: 200px;" type="date" name="firstDate" id="firstDate" min="2000-01-01" value="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" required>
                    <label for="secondDate">To: </label>
                    <input style="text-align: center;display: block;margin: auto;width: 200px;" type="date" name="secondDate" id="secondDate" min="2000-01-01" value="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">

    <div class="row justify-content-center align-items-center">
      <div class="col-10 mx-auto">
        <div class="type">Incomes</div>
      </div>
    </div>
    <div class="row justify-content-center align-items-center">
      <div class="col-8  col-md-5 table-responsive">
        <table class="content-table table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Category</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php
            require "functions.php";

            $sqlCommand = 'SELECT cat.name,inc.amount FROM
            incomes_category_assigned_to_users AS cat,incomes AS inc
            WHERE inc.user_id = ' . $_SESSION['userId'] . ' AND cat.id = inc.income_category_assigned_to_user_id AND cat.user_id = inc.user_id AND date_of_income BETWEEN \'' . previousMonthStartDate() . '\' AND \'' . previousMonthEndDate() . '\' ORDER BY inc.amount DESC;';
            echo getOperationRecords($sqlCommand,"income");
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-8  col-md-6">
        <div style="width: 300px; margin: auto;">
          <canvas style="display: inline-block;" id="myChart"></canvas>
        </div>
      </div>
    </div>

    <div class="row justify-content-center align-items-center">
      <div class="col-10 mx-auto">
        <div class="type">Expenses</div>
      </div>
      <div class="col-8  col-md-5 table-responsive">
        <table class="content-table table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Category</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php
            require_once "functions.php";
            
            $sqlCommand = 'SELECT cat.name,ex.amount FROM
          expenses_category_assigned_to_users AS cat,expenses AS ex
          WHERE ex.user_id = ' . $_SESSION['userId'] . ' AND cat.id = ex.expense_category_assigned_to_user_id AND cat.user_id = ex.user_id AND date_of_expense BETWEEN \'' . previousMonthStartDate() . '\' AND \'' . previousMonthEndDate() . '\' ORDER BY ex.amount DESC;';
            echo getOperationRecords($sqlCommand,"expense");
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-8  col-md-6">
        <div style="width: 300px; margin: auto;">
          <canvas style="display: inline-block;" id="myChartOne"></canvas>
        </div>
      </div>
    </div>
    </main>

    <div class="summary">
      Balance: <span class="balance"></span>
    </div>

    <?php
    $con = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);
    $sqlIncomeQuery = 'SELECT cat.name,SUM(inc.amount) FROM
  incomes_category_assigned_to_users AS cat,incomes AS inc
  WHERE inc.user_id = ' . $_SESSION['userId'] . ' AND cat.id = inc.income_category_assigned_to_user_id AND cat.user_id = inc.user_id AND date_of_income BETWEEN \'' . previousMonthStartDate() . '\' AND \'' . previousMonthEndDate() . '\' GROUP BY cat.name;';

    $query = $con->query($sqlIncomeQuery);


    if($query->num_rows !=0){
    foreach ($query as $data) {
      $category[] = $data['name'];
      $amount[] = $data['SUM(inc.amount)'];
    }
  }
  else {
    $category[] = '';
    $amount[] = '';
  }

    $query->free();

    $sqlExpenseQuery = 'SELECT cat.name,SUM(inc.amount) FROM
  expenses_category_assigned_to_users AS cat,expenses AS inc
  WHERE inc.user_id = ' . $_SESSION['userId'] . ' AND cat.id = inc.expense_category_assigned_to_user_id AND cat.user_id = inc.user_id AND date_of_expense BETWEEN \'' . previousMonthStartDate() . '\' AND \'' . previousMonthEndDate() . '\' GROUP BY cat.name;';

    $query = $con->query($sqlExpenseQuery);


    if($query->num_rows !=0){
    foreach ($query as $expenseData) {
      $expenseCategory[] = $expenseData['name'];
      $expenseAmount[] = $expenseData['SUM(inc.amount)'];
    }
  }
    else {
      $expenseCategory[] = '';
      $expenseAmount[] = '';
    }
    ?>


    <script>
      const incomeTotalAmount = parseFloat(document.querySelector('.income-total').textContent);
      const expenseTotalAmount = parseFloat(document.querySelector('.expense-total').textContent);

      let balance = incomeTotalAmount - expenseTotalAmount;
      balance = balance.toFixed(2);
      const balanceDiv = document.querySelector('.balance');

      if (balance >= 0) {
        balanceDiv.textContent = "+" + balance;
        balanceDiv.style.color = 'green';
      } else {
        balanceDiv.textContent = balance;
        balanceDiv.style.color = 'red';
      }
    </script>

    <script>
      const data = {
        labels: <?php echo json_encode($category) ?>,
        datasets: [{
          label: 'My First Dataset',
          data: <?php echo json_encode($amount) ?>,
          backgroundColor: ["#ea5545", "#f46a9b", "#ef9b20", "#edbf33", "#ede15b", "#bdcf32", "#87bc45", "#27aeef", "#b33dc6"],
          hoverOffset: 4
        }]
      };

      const config = {
        type: 'doughnut',
        data: data,
        options: {}
      };

      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );

      const dataSecond = {
        labels: <?php echo json_encode($expenseCategory) ?>,
        datasets: [{
          label: 'My First Dataset',
          data: <?php echo json_encode($expenseAmount) ?>,
          backgroundColor: ["#fd7f6f", "#7eb0d5", "#b2e061", "#bd7ebe", "#ffb55a", "#ffee65", "#beb9db", "#fdcce5", "#8bd3c7"],
          hoverOffset: 4
        }]
      };

      const configSecond = {
        type: 'doughnut',
        data: dataSecond,
        options: {}
      };

      const myChartOne = new Chart(
        document.getElementById('myChartOne'),
        configSecond
      );
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>