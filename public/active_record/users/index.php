<?php
require_once('../../../private/initialize.php');

$users = User::find_all();

$page_title = 'All Users';

include(SHARED_PATH . '/user_header.php');
?>

<a href="<?php echo url_for('/active_record/users/new.php') ?>">Add User</a>

<h2>All Users</h2>

<table>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name </th>
        <th>Email</th>
        <th>User Level</th>
        <th>Active</th>
        <th>Date Joined</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>


    </tr>

    <?php foreach ($users as $user) { ?>
        <tr>
            <td><?php echo h($user->id); ?></td>
            <td><?php echo h($user->username); ?></td>
            <td><?php echo h($user->f_name); ?></td>
            <td><?php echo h($user->l_name); ?></td>
            <td><?php echo h($user->email_address); ?></td>
            <td><?php echo find_value_from_lookup(h($user->role_id), 'role'); ?></td>
            <td><?php echo h($user->active_display()); ?></td>
            <td><?php echo h($user->joined_at); ?></td>

            <td><a href="<?php echo url_for('/active_record/users/show.php?id=' . h(u($user->id))); ?>">View</a></td>
            <td><a href="<?php echo url_for('/active_record/users/edit.php?id=' . h(u($user->id))); ?>">Edit</a></td>
            <td><a href="<?php echo url_for('/active_record/users/delete.php?id=' . h(u($user->id))); ?>">Delete</a></td>
        </tr>
    <?php } ?>
</table>


<?php include(SHARED_PATH . '/user_footer.php'); ?>
