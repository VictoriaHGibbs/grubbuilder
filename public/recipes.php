<?php 
require_once('../private/initialize.php');

$page_title = 'Recipes';

include(SHARED_PATH . '/public_header.php');
?>
<h2>All the Recipes</h2>

<?php

$id = rand(1, 9);
$recipe = Recipe::find_by_id($id);
echo $recipe->display();
echo Recipe::user_info($recipe);

echo Recipe::ingredients($id);
echo Recipe::directions($id);

$recipes = Recipe::find_all();
?>

<section class="card-preview-container">

<?php foreach($recipes as $recipe) { ?>
  <section class="recipe-card-preview">
    <a href="detail.php?id=<?php echo $recipe->id; ?>">
    <h3><?php echo h($recipe->recipe_title); ?></h3>
    <p><?php echo h($recipe->user_info($recipe)) ?></p>
    <p><?php echo h($recipe->description); ?></p>
    </a>
  </section>

<?php } ?>

</section>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
