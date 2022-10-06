<?php

require_once 'connect.php';

function endMonthDate () {
  $date = date("Y-m-t");
  return $date;
}

function startMonthDate () {
  $date = date("Y-m-01");
  return $date;
}

function previousMonthStartDate () {
  $date = date('Y-m-01', strtotime('-1 month'));
  return $date;
}

function previousMonthEndDate () {
  $date = date('Y-m-t', strtotime('-1 month'));
  return $date;
}

function checkIfLoginHasBadChars($login)
{
  return ctype_alnum($login);
}

function checkIfAddressEmailIsCorrect($email)
{

  $emailAfterCleaning = filter_var($email, FILTER_SANITIZE_EMAIL);

  if (filter_var($email, FILTER_SANITIZE_EMAIL) == false || $emailAfterCleaning != $email) {
    return false;
  } else {
    return true;
  }
}

function checkIfPasswordIsCorrect($password)
{
  if (preg_match('~[0-9]+~', $password) == false) {
    return false;
  }
  return ctype_alnum($password);
}

function checkIfNameIsCorrect($name)
{
  if (preg_match('~[0-9]+~', $name)) {
    return false;
  }
  return ctype_alnum($name);
}

function getCategories($sqlCommand)
{
  require "connect.php";

  try {
    $connection = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);
    if ($connection->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    }
    $result = $connection->query($sqlCommand);
    if (!$result) throw new Exception($connection->error);

    $string = '';

    while ($data = $result->fetch_assoc()) {
      $string .= '<option value = "' . $data['id'] . '">' . $data['name'] . '</option>';
    }
    $connection->close();
    $result->free();
    return $string;
  } catch (Exception $e) {
    echo 'Server error';
  }
}

function getOperationRecords($sqlCommand,$operationType)
{
  require "connect.php";

  try {
    $connection = new mysqli($serverName, $dbUsername, $dbPassword, $dbName);
    if ($connection->connect_errno != 0){
      throw new Exception(mysqli_connect_errno());
    }

    $result = $connection->query($sqlCommand);
    $string = '';
    $rank = 1;
    $sumOfIncomes = 0;

    while ($data = $result->fetch_assoc()) {
      $sumOfIncomes += $data['amount'];
      $string .= '<tr><td>' . $rank . '</td> <td>' . $data['name'] . '</td> <td class = "'. $operationType .'-amount">' . $data['amount'] . '</td></tr>';
      $rank++;
    }
    $string .= '<tr class = "last"> <td> </td><td>Total: </td> <td class = "'.$operationType.'-total">' . $sumOfIncomes . '</td> </tr>';
    $connection->close();
    $result->free();
    return $string;
  } catch (Exception $e) {
    echo 'Server error';
  }
}
