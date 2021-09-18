<?php
//always start the session first
session_start();

//error reporting, to be removed
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../../Functions/databaseConnection.php');

//ensure that the data being sent is in the form of a POST
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  //take the access code from the Post
  $accessCode = $_POST['accessCode'];
  $printaccessCode = strval($accessCode);
  //echo $printaccessCode;
  //check if there is a device with the given access code, if there is return the device record.
  $codeRecord = getAccessCodeRecord($accessCode, $pdo);
  //If a user record is returned, and the record is not empty then activate the user's account
  //echo $deviceAccessCode;

  if (!empty($codeRecord['accessCode']))
  {
    //Log user in
    //setcookie("accessSuccess", "Logged in Successfully!", time() + 300, "/");
    setcookie("accessFailure", "", time() -1000, "/");
    $_SESSION['deviceAccessCode'] = $codeRecord['accessCode'];
    //echo 'Logged in';

    header("Location: orderPage");
  }
  //else set cookie to fail and redirect user back to the accountActivation page
  else

  {
    setcookie("accessFailure", "Access Code Invalid - Please try again.", time() + 300, "/"); //Create an activation error cookie with the string value, lasts for 300s
    header("Location: orderLogin");

  }
}



function getAccessCodeRecord($_accessCode,$_pdo)
{
  //Prepare the sql query, get all from table with the access Code
  $query = $_pdo->prepare("SELECT * FROM Devices WHERE accessCode = :accessCode LIMIT 1");
  $query->execute(["accessCode"=>$_accessCode]);
  return $query->fetch();
}

?>
