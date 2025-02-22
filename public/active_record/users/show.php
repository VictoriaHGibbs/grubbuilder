<?php
require_once('../../../private/initialize.php');

$id = $_GET['id'] ?? false;

$user = User::find_by_id($id);

$page_title = 'Show User: ' . $user->username;


include(SHARED_PATH . '/user_header.php');
?>

<a href="<?php echo url_for('/active_record/users/index.php'); ?>">Return to List</a>

<h2>Show User Details for: <?php echo h($user->username); ?></h2>

<dl>
    <dt>First Name:</dt>
    <dd><?php echo h($user->f_name); ?></dd>
</dl>
<dl>
    <dt>Last Name:</dt>
    <dd><?php echo h($user->l_name); ?></dd>
</dl>
<dl>
    <dt>Email:</dt>
    <dd><?php echo h($user->email_address); ?></dd>
</dl>
<dl>
    <dt>User Name:</dt>
    <dd><?php echo h($user->username); ?></dd>
</dl>
<dl>
    <dt>Role:</dt>
    <dd><?php echo find_value_from_lookup(h($user->role_id), 'role') ; ?></dd>
</dl>
<dl>
    <dt>Date Joined:</dt>
    <dd><?php echo h($user->joined_at); ?></dd>
</dl>
<dl>
    <dt>Account Status:</dt>
    <dd><?php echo h($user->active_display()); ?></dd>
</dl>

<?php include(SHARED_PATH . '/user_footer.php'); ?>
