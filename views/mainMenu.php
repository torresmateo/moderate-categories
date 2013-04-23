<!-- Main Menu Template

Shows the role-category rules table and the "Add Rule" button

Mateo Torres 2013-->

<?php 

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

//include the header file
include("template/header.php");?>

<form action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data" name="update_roles_rules">
    <h2>Category rules for Roles</h2>
    <table class="widefat post moderateTable" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Role</th>
                <th scope="col" class="manage-column">Categories</th>
                <th scope="col" class="manage-column">Add</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="manage-column">Role</td>
                <th class="manage-column">Categories</td>
                <th class="manage-column">Add</td>
            </tr>
        </tfoot>
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

<form action="<?php echo $PHP_SELF; ?>" class="moderateForm" method="post" enctype="multipart/form-data" name="add_new_role_rule">
    <table class="widefat post">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Add/Edit New Rule</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="manage-column moderateSubmitCol"><input type="submit" value="Add/Edit"/></th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <select name="role">
                        <?php
                        $roles = get_editable_roles();
                        foreach($roles as $role => $roleDetails){
                            echo '<option value="'.$role.'">'.$roleDetails['name'].'</option>"';
                        }
                        ?>
                    </select>
                    <div class="taxonomydiv">
	                    <ul class="categorychecklist form-no-clear">
	                        <?php
	                        $configAccess = new ConfigurationAccess();
	                        $walker = new RestrictCats_Walker_Category_Checklist();
	                        if ( isset( $settings[ $id ] ) && is_array( $settings[ $id ] ) )
								$selected = $settings[ $id ];
							else
								$selected = array();
	                        wp_list_categories(
	                            array(
	                                'admin'          => $id,
	                                'selected_cats'  => $selected,
	                                'options_name'   => $options_name,
	                                'hide_empty'     => 0,
	                                'title_li'       => '',
	                                'disabled'       => false,
	                                'walker'         => $walker
	                            )
	                        );

	                        $disable_checkbox = ( 'all' == $current_tab ) ? '' : 'disabled="disabled"';
	                        ?>
	                        <input style="display:none;" <?php echo $disable_checkbox; ?> type="checkbox" value="RestrictCategoriesDefault" checked="checked" name="<?php echo $options_name; ?>[<?php echo $id; ?>][]">
	                    </ul>
	                </div>
                </td>
            </tr>
        </tbody>
</form>

<?php //include the footer file
include("template/footer.php");?>



















