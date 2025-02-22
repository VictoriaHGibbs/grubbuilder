<?php

require_once('../../../private/initialize.php');

// require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/active_record/users/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
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

    <form action="<?php echo url_for('/active_record/users/delete.php?id=' . h(u($id))); ?>" method="post">

        <input type="submit" name="commit" value="Delete User">
     
    </form>


<?php include(SHARED_PATH . '/user_footer.php'); ?>
