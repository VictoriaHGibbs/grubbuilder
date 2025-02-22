<?php
require_once('../../private/initialize.php');

// require_login();
$user_id = $_SESSION['user_id'] ?? false;
$recipes = Recipe::find_by_user($user_id);
var_dump($recipes);

$page_title = 'User Menu/ Main Profile Page';

include(SHARED_PATH . '/user_header.php');
?>

<h2>Welcome back <?php echo h(User::get_username_by_id($user_id)); ?> </h2>
<ul>

  <!-- will be for admin only  -->
  <li><a href="<?php echo url_for('/active_record/users/index.php'); ?>">Users</a></li>


  <li><a href="<?php echo url_for('/active_record/recipes/index.php'); ?>">All Recipe list</a></li>

</ul>

<h2>All Your Recipes</h2>

<section class="card-preview-container">

<?php foreach($recipes as $recipe) { ?>
  <section class="recipe-card-preview">
    <a href="recipes/show.php?recipe_id=<?php echo $recipe->recipe_id; ?>">
    <h3><?php echo h($recipe->recipe_title); ?></h3>
    <p><?php echo h($recipe->description); ?></p>
    <p><?php echo find_value_from_lookup(h($recipe->visibility_id), 'visibility'); ?></p>
    
    </a>
  </section>

<?php } ?>

</section>


<?php include(SHARED_PATH . '/user_footer.php'); ?>
