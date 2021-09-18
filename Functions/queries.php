<?
function getDrinkInformationFromID($_drinkID,$_pdo)
{
  //Prepare the sql query, get all from table with the given device ID in descending order but only the first
  $query = $_pdo->prepare("SELECT drinkName, image FROM Drinks WHERE drinkID = :drinkID LIMIT 1");
  $query->execute(["drinkID"=>$_drinkID]);
  return $query->fetch();
}
function getDrinkIngredientsFromID($_drinkID,$_pdo)
{
  //Prepare the sql query, get all from table with the given device ID in descending order but only the first
  $query = $_pdo->prepare("SELECT Ingredients.ingredientName FROM ((DrinkIngredients INNER JOIN Drinks ON DrinkIngredients.drinkID = Drinks.drinkID) INNER JOIN Ingredients ON DrinkIngredients.ingredientID = Ingredients.ingredientID) WHERE Drinks.drinkID = :drinkID");
  $query->execute(["drinkID"=>$_drinkID]);
  return $query->fetchAll();
}

function getDrinkIngredients($_pdo)
{
  //SQL query
  $query = $_pdo -> prepare("SELECT Drinks.drinkName, Ingredients.ingredientName, Drinks.drinkID, Drinks.image FROM (((DrinkIngredients INNER JOIN AvailableDrinks ON AvailableDrinks.availableDrinkID = DrinkIngredients.drinkID) INNER JOIN Drinks ON DrinkIngredients.drinkID = Drinks.drinkID) INNER JOIN Ingredients ON DrinkIngredients.ingredientID = Ingredients.ingredientID)");
  //Execute the sql query and return
  $query->execute();
  return $query->fetchAll();
}
?>
