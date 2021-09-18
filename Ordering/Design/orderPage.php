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
  <link rel="stylesheet" type="text/css" href="orderCSS">
  <!-- Icon at top of page -->
  <title>Order</title>

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
      <div class="orderInformation container">
        Please choose one of the following delicious cocktails by clicking on the cocktail's picture:
      </div>


      <div class="cardContainer">
        <div class="card-deck">
          <?php
          ini_set('display_errors', '1');
          ini_set('display_startup_errors', '1');
          error_reporting(E_ALL);
          include('../../Functions/databaseConnection.php');
          include('../../Functions/queries.php');
          $drinkIngredients = getDrinkIngredients($pdo);


          if( !sizeof($drinkIngredients) == 0 )
          {
            $previousDrinkID = 0;
            $arrayCount = -1;
            $ingredientCount = 0;
            $drinkIngredientsArray = [];
            $drinkNamesArray=[];
            $drinkImagesArray=[];
            $drinkIDArray=[];

            foreach($drinkIngredients as $drink)
            {
              $currentDrinkID = $drink['drinkID'];
              if ($previousDrinkID!=$currentDrinkID)
              {
                $ingredientCount = 0;
                $previousDrinkID = $currentDrinkID;
                $arrayCount++;
                $drinkNamesArray[$arrayCount] = $drink['drinkName'];
                $drinkImagesArray[$arrayCount] = $drink['image'];
                $drinkIDArray[$arrayCount] = $drink['drinkID'];
              }

              //echo 'current drink is',$currentDrinkID,'array count is',$arrayCount, ' ingredientCount is',$ingredientCount,'<br>';
              $drinkIngredientsArray[$arrayCount][$ingredientCount] = $drink['ingredientName'];
              //echo $drink['ingredientName'],'<br>';
              $ingredientCount++;



            }
            //echo $drinkIngredientsArray[0][1],'<br>';
            //echo $drinkIngredientsArray[1][1],'<br>';


          }

          for ($arrayCount = 0; $arrayCount < count($drinkIngredientsArray); $arrayCount++)
          {
            echo '
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">',$drinkNamesArray[$arrayCount],'</h5>
                <ul>
                  ';
                  for ($ingredientCount = 0; $ingredientCount < count($drinkIngredientsArray[$arrayCount]); $ingredientCount++)
                  {
                    echo '<li>',$drinkIngredientsArray[$arrayCount][$ingredientCount];
                  }
                  echo '
                </ul>
              </div>
              <a href ="Ordering/Design/orderConfirmation.php?drink=',$drinkIDArray[$arrayCount],'">
                <img class="card-img-top" src="images/drinks/',$drinkImagesArray[$arrayCount],'" width="100px"  alt="Card image cap">
              </a>
            </div>
            ';
          }











          ?>




        </div>
      </div>

    </body>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>
