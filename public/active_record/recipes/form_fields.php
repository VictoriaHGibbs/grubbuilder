<?php 


// if (!isset($recipe)) {
//   redirect_to(url_for('active_record/recipes.index.php'));
// }
// ?>

  <label for="recipe_title">Recipe Title: </label>
  <input type="text" id="recipe_title" name="recipe_title" maxlength="100" required>
  <br>
  
  <label for="description">Description: </label>
  <br>
  <textarea id="description" name="description" maxlength="255" required></textarea>
  <br>

  <label for="prep_time_minutes">Preparation time: </label>
  <input type="number" id="prep_time_minutes" name="prep_time_minutes" required>
  <br>

  <label for="cook_time_minutes">Cooking time: </label>
  <input type="number" id="cook_time_minutes" name="cook_time_minutes" required>
  <br>
  
  <fieldset>
    <label for="yield">Yield: </label>
    <input type="number" id="yield" name="yield" required>
    
    <label for="measurement_id">Select Unit:</label>
    <select id="measurement_id" name="yield_measurement_id">
      <option value="">Units</option>
      <?php all_from_lookup('measurement');?>
    </select>
  </fieldset>

  <label for="servings">Servings</label>
  <input type="number" id="servings" name="servings" required>
  <br>

  <label for="visibility_id">Select Visibility:</label>
  <select id="visibility_id" name="visibility_id" required>
    <option value="">Visibility Options</option>
    <?php all_from_lookup('visibility');?>
  </select>
  <br>

  <fieldset id="ingredient">
    <legend>Ingredients</legend>
    <label for="quantity">Quantity: </label>
    <input type="number" id="quantity" name="quantity[]" required>
    
    <label for="ing_measurement_id">Select Unit: </label>
    <select id="ing_measurement_id" name="measurement_id[]">
      <option value="">Units</option>
      <?php all_from_lookup('measurement');?>
    </select>
    
    <label for="ingredient_name">Ingredient: </label>
    <input type="text" id="ingredient_name" name="ingredient_name[]" required>
    <br>
    <input type="submit" value="Submit and Add another" id="add-ingredient">
  </fieldset>
  
  <fieldset id="direction">
    <legend>Directions</legend>
    <label for="direction_text">Enter one at a time: </label>
    <input type="text" id="direction_text" name="direction_text[]" required>
    <br>
    <input type="submit" value="Submit and Add another" id="add-direction">
  </fieldset>

  <fieldset>
    <legend>Images</legend>
    <label for="image">Upload: </label>
    <input type="file" id="image" name="image_url[]" accept="image/*">
    <br>
    <input type="button" value="Add Another Image" id="add-image">
  </fieldset>

  <label for="youtube_url">YouTube Video Share Link - PLACEHOLDER:</label>
  <input type="text" id="youtube_url" name="youtube_url" required>
  <br>

  <label for="meal_type">Select Meal Type:</label>
  <select id="meal_type" name="meal_type_id">
    <option value="">Meal Types</option>
    <?php all_from_lookup('meal_type');?>
  </select>
  <br>

  <label for="diet">Select Diet:</label>
  <select id="diet" name="diet_id">
    <option value="">Diets</option>
    <?php all_from_lookup('diet');?>
  </select>
  <br>

  <label for="style">Select Style:</label>
  <select id="style" name="style_id">
    <option value="">Styles</option>
    <?php all_from_lookup('style');?>
  </select>

