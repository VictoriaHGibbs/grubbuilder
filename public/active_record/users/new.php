<?php

require_once('../../../private/initialize.php');
// require_admin_login();

if (is_post_request()) {

    // Create record using post parameters
    $args = $_POST['user'];
    $user = new User($args);
    $result = $user->save();


    if ($result === true) {
        $new_id = $user->user_id;
        $session->message('The user was created successfully.');
        redirect_to(url_for('/active_record/users/show.php?user_id=' . $new_id));
    } else {
        // show errors
    }
} else {
    // display the form
    $user = new User;
}

?>

<?php $page_title = 'Create User'; ?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<a href="<?php echo url_for('/active_record/users/index.php'); ?>">&laquo; Back to User List</a>


<h1>Create User</h1>

<?php echo display_errors($user->errors);
?>

<form action="<?php echo url_for('/active_record/users/new.php'); ?>" method="post">

    <?php include('form_fields.php'); ?>


    <input type="submit" value="Create User">

</form>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
