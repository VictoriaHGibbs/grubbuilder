<?php

require_once('../../private/initialize.php');

if (is_post_request()) {

  // Create record using post parameters
  $args = $_POST['user'];
  $user = new User($args);
  $result = $user->save();


  if ($result === true) {
    $new_id = $user->id;
    redirect_to(url_for('/active_record/login.php'));
  } else {
    // show errors
  }
} else {
  // display the form
  $user = new User;
}

?>

<?php $page_title = 'Sign Up'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

  <a href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <h2>Sign up and Create an account!</h2>

    <?php echo display_errors($user->errors);
    ?>

    <form action="<?php echo url_for('/active_record/signup.php'); ?>" method="post">

      <?php include('../active_record/users/form_fields.php'); ?>

      <input type="submit" value="Sign up">

    </form>


<?php include(SHARED_PATH . '/public_footer.php'); ?>
