<!-- Main Menu Template

Shows the role-category rules table and the "Add Rule" button

Mateo Torres 2013-->

<?php 
//include the header file
include("template/header.php");?>

<form action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data" name="update_roles_rules">
    <h2>Category rules for Roles</h2>
    <table class="widefat post" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Role</th>
                <th scope="col" class="manage-column">Categories</th>
                <th scope="col" class="manage-column">Add</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>asdf</td>
                <td>
                    <ul>
                        <li>asdf</li>
                        <li>asdf</li>
                        <li>asdf</li>
                        <li>asdf</li>
                        <li>asdf</li>
                        <li>asdf</li>
                    </ul>
                </td>
                <td>
                    EDITAR
                </td>
            </tr>
        </tbody>
    </table>
</form>

<?php //include the footer file
include("template/footer.php");?>
