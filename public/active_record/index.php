<?php
require_once('../../private/initialize.php');

// require_login();

$page_title = 'User Menu';

include(SHARED_PATH . '/user_header.php');
?>

<h2>Main Menu</h2>
<ul>

  
  <li><a href="<?php echo url_for('/active_record/users/index.php'); ?>">Users</a></li>
  

  <li><a href="<?php echo url_for('/active_record/recipes/index.php'); ?>">All Recipe list</a></li>


</ul>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
