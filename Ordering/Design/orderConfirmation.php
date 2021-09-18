<?php
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['deviceAccessCode']))
{
  header("Location: orderLogin");
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/png" href="images/cocktailbotsmall.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/cocktailbot/orderCSS">
  <!-- Icon at top of page -->
  <title>Order Confirmation</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Cardo:400,700|Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Archivo:500|Open+Sans:300,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Chivo:300,700|Playfair+Display:700i" rel="stylesheet">

</head>
    <body>
      <div class="orderTitle centeredContainer container-fluid">
        Welcome to Cocktailbot 🍹
      </div>

      <div class="orderInformation centeredContainer">
        Is this the correct cocktail, please press the 'correct' or 'incorrect' button:
      </div>
      <div class="smallPadding"></div>
      <div class="smallPadding"></div>

      <div class="container buttonContainer centeredContainer">
        <div class="row">
          <div class="col w-50">
            <form action="/cocktailbot/orderSubmit" method = "post">
              <?
              echo '<button class="btn btn-success btn-lg active" name="drinkID" value="'.$_GET["drink"].'" aria-pressed="true">Correct Drink - Order</a>'
              ?>

          </div>
          <div class="col w-50">
            <a href="/cocktailbot/orderPage" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">Incorrect Drink - Cancel</a>
          </div>

        </div>
      </div>


      <?
      include('../../Functions/queries.php');
      include('../../Functions/databaseConnection.php');
      $drinkID = $_GET["drink"];
      $drinkIngredients = getDrinkIngredientsFromID($drinkID,$pdo);
      $drinkInformation = getDrinkInformationFromID($drinkID, $pdo);
      $drinkName = $drinkInformation['drinkName'];
      $image = $drinkInformation['image'];
      $ingredientsArray = [];
      $arrayCount = 0;
      foreach($drinkIngredients as $drinkIngredient)
      {
          $ingredientsArray[$arrayCount] = $drinkIngredient['ingredientName'];
          $arrayCount++;
      }

      //Generate card
      echo '
      <div class="cardConfirmationContainer">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">',$drinkName,'</h5>
            <ul>
              ';
              for ($ingredientCount = 0; $ingredientCount < count($ingredientsArray); $ingredientCount++)
              {
                echo '<li>',$ingredientsArray[$ingredientCount];
              }
              echo'
            </ul>

          </div>
            <img class="card-img" src="/cocktailbot/images/drinks/',$image,'" width="200px"  alt="Card image cap">
        </div>
      </div>
      ';
      ?>


    </body>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>
