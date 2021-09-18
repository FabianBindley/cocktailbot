<?php
//always start the session first
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['deviceAccessCode']))
{
  header("Location: orderLogin");
}

//error reporting, to be removed
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../../Functions/databaseConnection.php');

//ensure that the data being sent is in the form of a POST
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  //take the access code from the Post
  $drinkID = $_POST['drinkID'];
  $deviceAccessCode = $_SESSION['deviceAccessCode'];
  $latestOrder = addOrder($drinkID,$deviceAccessCode,time(),$pdo);
  if($latestOrder['id'] > 0)
  {
    //Order successfully made
    header("Location: /cocktailbot/Ordering/Design/orderSuccess.php?drink=".$latestOrder['id']);
  }
  else {
    header("Location: orderFailed");
  }
}

function addOrder($_drinkID,$_deviceAccessCode,$_epochTime,$_pdo){
  //Create the sql query that will add deviceID and dataValue to the database

  $query = $_pdo->prepare("INSERT INTO Orders (drinkID,deviceAccessCode, epochTime) VALUES (:drinkID, :deviceAccessCode, :epochTime)");
  //prepared queries are safer and sql injection proof
  // inserts the email, password, first and last names and since the account has just been created, it is active so set to 0.
  //the level of access by default is also set to 1
  $query->execute(["drinkID"=>$_drinkID, "deviceAccessCode"=>$_deviceAccessCode, "epochTime"=>$_epochTime]);

  $query = $_pdo->prepare("SELECT id FROM Orders ORDER BY id DESC LIMIT 1");
  $query->execute();
  return $query->fetch();
}







?>
