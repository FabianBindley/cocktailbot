<?php
$host = 'localhost';
$db = 'cocktailbot';
$user = 'cocktailbot';
$pass = 'kP9e0##BeBwi%dwoVoeTCF';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try
{
  //initiating the PHP data object, passing in the DB admin credentials as parameters
  $pdo = new PDO($dsn, $user, $pass, $options);

}
//If there is an issue return it
catch(PDOException $e)
{
  throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
