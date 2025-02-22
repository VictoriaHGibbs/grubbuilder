<?php 
require_once('../../../private/initialize.php');

$recipes = Recipe::find_all();

$page_title = 'All Recipes';

include(SHARED_PATH . '/user_header.php');
?>

<a href="<?php echo url_for('/active_record/recipes/new.php') ?>">Add Recipe</a>

<h2>All the Recipes</h2>


<section class="card-preview-container">

<?php foreach($recipes as $recipe) { ?>
  <section class="recipe-card-preview">
    <a href="show.php?recipe_id=<?php echo $recipe->recipe_id; ?>">
    <h3><?php echo h($recipe->recipe_title); ?></h3>
    <p><?php echo h($recipe->user_info($recipe)) ?></p>
    <p><?php echo h($recipe->description); ?></p>
    </a>
  </section>

<?php } ?>

</section>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
