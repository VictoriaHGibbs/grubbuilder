<?php

require_once('../../../private/initialize.php');

// require_login();

if(!isset($_GET['user_id'])) {
  redirect_to(url_for('/active_record/users/index.php'));
}
$user_id = $_GET['user_id'];
$user = User::find_by_pk($user_id);
if($user == false) {
  redirect_to(url_for('/active_record/users/index.php'));
}

if(is_post_request()) {
  $result = $user->delete();
  $session->message('The user was deleted successfully.');
  redirect_to(url_for('/active_record/users/index.php'));

} else {
  // Display form
}

?>

<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

  <a href="<?php echo url_for('/active_record/users/index.php'); ?>">Back to List</a>

    <h1>Delete User</h1>
    <p>Are you sure you want to delete this user?</p>
    <p><?php echo h($user->username); ?></p>

    <form action="<?php echo url_for('/active_record/users/delete.php?user_id=' . h(u($user_id))); ?>" method="post">

        <input type="submit" name="commit" value="Delete User">
     
    </form>


<?php include(SHARED_PATH . '/user_footer.php'); ?>
