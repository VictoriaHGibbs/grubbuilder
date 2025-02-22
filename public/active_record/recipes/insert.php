<?php 

// Transaction to insert rows into multiple tables at once

$database->begin_transaction();

try {
// Prepare and bind RECIPE table
  $stmt1 = $database->prepare("INSERT INTO recipe (user_id, recipe_title, prep_time_minutes, cook_time_minutes, description, yield, measurement_id, servings, visibility_id) VALUES (?,?,?,?,?,?,?,?,?)");
  $stmt1->bind_param("isiisiiii", $_SESSION['user_id'], $_POST['recipe_title'], $_POST['prep_time_minutes'], $_POST['cook_time_minutes'], $_POST['description'], $_POST['yield'], $_POST['yield_measurement_id'], $_POST['servings'], $_POST['visibility_id']);
  $stmt1->execute();

// Get last inserted recipe_id
  $recipe_id = $database->insert_id;

// Prepare INGREDIENT table
  $stmt2 = $database->prepare("INSERT INTO ingredient (recipe_id, ingredient_line_item, quantity, ingredient_name, measurement_id, sort_order) VALUES (?,?,?,?,?,?)");
// Loop 
  foreach ($_POST['quantity'] as $index => $quantity) {
    $ingredient_line_item = $index + 1;
    $stmt2->bind_param("iiisii", $recipe_id, $ingredient_line_item, $quantity, $_POST['measurement_id'][$index], $_POST['ingredient_name'][$index], $ingredient_line_item);
    $stmt2->execute();
  }
// Prepare and bind DIRECTION table
  $stmt3 = $database->prepare("INSERT INTO direction (recipe_id, direction_line_item, direction_text, sort_order) VALUES (?,?,?,?)");
// Loop
  foreach ($_POST['direction_text'] as $index => $direction_text) {
    $direction_line_item = $index + 1;
    $stmt3->bind_param("iisi", $recipe_id, $direction_line_item, $_POST['direction_text'], $direction_line_item);
    $stmt3->execute();
  }
// Check if image
  if (has_presence($_POST['image_url'])) {
// Prepare and bind IMAGE table
    $stmt4 = $database->prepare("INSERT INTO image (recipe_id, image_line_item, image_url, sort_order) VALUES (?,?,?,?)");
// Loop
    foreach ($_POST['image_url'] as $index => $image_url) {
    $image_line_item = $index + 1;
    $stmt4->bind_param("iisi", $recipe_id, $image_line_item, $_POST['image_url'], $image_line_item);
    $stmt4->execute();
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
