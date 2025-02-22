<?php
require_once('../../../private/initialize.php');

$id = $_GET['recipe_id'] ?? false;

$recipe = Recipe::find_by_pk($id);

$page_title = 'Detail: ' . $recipe->recipe_title;


include(SHARED_PATH . '/user_header.php');
?>

<ul>
  <li><a href="<?php echo url_for('/active_record/recipes/index.php'); ?>">All Recipes</a></li>
  <li><a href="<?php echo url_for('/active_record/index.php'); ?>">Your Recipes</a></li>
</ul>

<section>
    <section>
        <h2><?php echo h($recipe->recipe_title); ?></h2>
        <p><?php echo h($recipe->user_info($recipe)) ?></p>
        <!-- RECIPE IMAGES -->
        <!-- RATING  -->
        <p><?php echo h($recipe->description); ?></p>
        <p>Prep Time: <?php echo h($recipe->prep_time_minutes); ?> minutes</p>
        <p>Cook Time: <?php echo h($recipe->cook_time_minutes); ?> minutes</p>
        <p>Servings: <?php echo h($recipe->servings); ?></p>
        <p>Yield: <?php echo h(abs($recipe->yield)) . " " . h($recipe->get_measurement_name($recipe));
                    if ($recipe->yield > 1) echo "s"; ?> </p>
        <!-- PRINTER FRIENDLY LINK -->
        <!-- ADD TO FAVORITES -->
        <!-- NUTRITION FACTS -->
        <?php $link = h($recipe->get_video($id)); ?>


    </section>

    <section>
        <h3>Ingredients</h3>
        <?php echo Recipe::ingredients($id); ?>
    </section>

    <section>
        <h3>Directions</h3>
        <?php echo Recipe::directions($id); ?>
    </section>

</section>


<?php include(SHARED_PATH . '/user_footer.php'); ?>
