<?php 

// Transaction to insert rows into multiple tables at once

$database->begin_transaction();

try {
// Prepare and bind RECIPE table
  $stmt1 = $_POST['recipe'];
  $recipe = new Recipe($stmt1);
  $stmt1_result = $recipe->save();

// Get last inserted recipe_id
  $recipe_id = $database->insert_id;

// Prepare INGREDIENT table
  $stmt2 = $_POST['ingredient'];
// Loop 
  foreach ($stmt2 as $index) {
    $ingredient_line_item = $index + 1;
    $ingredient = new Ingredient($stmt2);
    $stmt2_result = $ingredient->save();
  }
// Prepare and bind DIRECTION table
  $stmt3 = $_POST['direction'];
// Loop
  foreach ($stmt3 as $index) {
    $direction_line_item = $index + 1;
    $direction = new Direction($stmt3);
    $stmt3_result = $direction->save();
  }
// Check if image
  if (has_presence($_POST['image'])) {
// Prepare and bind IMAGE table
    $stmt4 = $_POST['image'];
// Loop
    foreach ($stmt4 as $index) {
      $image_line_item = $index + 1;
      $image = new Image($stmt4);
      $stmt4_result = $image->save();
    }
  }
// Check if video
  if (has_presence($_POST['youtube_url'])) {
// Prepare and bind VIDEO table
  $stmt5 = $database->prepare("INSERT INTO video (recipe_id, youtube_url) VALUES (?,?)");
  $stmt5->bind_param("is", $recipe_id, $_POST['youtube_url']);
  $stmt5->execute();
  }

// Check if meal_type
  if (has_presence($_POST['meal_type_id'])) {
// Prepare and bind RECIPE_MEAL_TYPE table
  $stmt6 = $database->prepare("INSERT INTO recipe_meal_type (meal_type_id, recipe_id) VALUES (?,?)");
  $stmt6->bind_param("ii", $_POST['meal_type_id'], $recipe_id);
  $stmt6->execute();
  }

// Check if diet
  if (has_presence($_POST['diet_id'])) {
// Prepare and bind RECIPE_DIET table
  $stmt7 = $database->prepare("INSERT INTO recipe_diet (diet_id, recipe_id) VALUES (?,?)");
  $stmt7->bind_param("ii", $_POST['diet_id'], $recipe_id);
  $stmt7->execute();
  }

// Check if style
  if (has_presence($_POST['style_id'])) {
// Prepare and bind RECIPE_STYLE table
  $stmt8 = $database->prepare("INSERT INTO recipe_style (style_id, recipe_id) VALUES (?,?)");
  $stmt8->bind_param("ii", $_POST['style_id'], $recipe_id);
  $stmt8->execute();
  }

// Commit transaction
  $database->commit();
  echo "Recipe creation successful!";

} catch (Exception $error) {
  // Rollback transaction if error
  $database->rollback();
  echo "Recipe not created! :( ";
}
