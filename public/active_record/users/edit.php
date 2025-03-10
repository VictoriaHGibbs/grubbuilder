<?php

require_once('../../../private/initialize.php');

// require_admin_login();

if (!isset($_GET['user_id'])) {
    redirect_to(url_for('/active_record/users/index.php'));
}
$user_id = $_GET['user_id'];
$user = User::find_by_pk($user_id);
if ($user == false) {
    redirect_to(url_for('/active_record/users/index.php'));
}

if (is_post_request()) {

    // Save record using post parameters
    $args = $_POST['user'];
    $user->merge_attributes($args);
    $result = $user->save();

    if ($result === true) {
        $session->message('The user was updated successfully.');
        redirect_to(url_for('/active_record/users/show.php?user_id=' . $user_id));
    } else {
        // show errors
    }

} else {

    // display the form

}

?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>



  <a href="<?php echo url_for('/active_record/users/index.php'); ?>">&laquo; Back to List</a>

 
    <h1>Edit User</h1>

    <?php echo display_errors($user->errors); ?>

    <form action="<?php echo url_for('/active_record/users/edit.php?user_id=' . h(u($user_id))); ?>" method="post">

      <?php include('form_fields.php'); ?>

     
      <input type="submit" value="Edit User">
     
    </form>

 



<?php include(SHARED_PATH . '/user_footer.php'); ?>
