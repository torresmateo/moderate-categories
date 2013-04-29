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
include("template/header.php");

$configAccess = new ConfigurationAccess();
$roleRules = $configAccess->getRolesConfiguration();
?>

    <h2>Category rules for Roles</h2>
    <table class="widefat post moderateTable" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Role</th>
                <th scope="col" class="manage-column">Categories</th>
                <th scope="col" class="manage-column">Reset</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="manage-column">Role</td>
                <th class="manage-column">Categories</td>
                <th class="manage-column">Reset</td>
            </tr>
        </tfoot>
        <tbody>
            <?php 
            	if(!empty($roleRules))
					foreach ($roleRules as $role => $categories) {
						echo "<tr><td>$role</td><td><ul>";
						$list = '';
						$jsArray = '<script> var '.$role.' = [';
						reset($categories);
						$firstKey = key($categories);
						foreach ($categories as $key => $category) {
							$name = get_category($category)->name;
							$slug = get_category($category)->slug;
							$list .= "<li>$name</li>";
							if($key != $firstKey)
								$jsArray .= ',';
							$jsArray .= "'".$slug."'";
						}
						$jsArray .= '];</script>';
						echo $list;
						echo "</ul></td>
						<td>".$jsArray."
							<form action='".$PHP_SELF."' method='post' enctype='multipart/form-data' name='update_roles_rules'>
								<input type='hidden' name='target' value='".$role."' />
								<input type='hidden' name='runMe' value='resetRole' />
								<input type='submit' value='Delete'/>
							</form>
						</td>

						</tr>";
					}
				else
					echo "<tr><td/><td><h1>No rules</h1></td><td/></tr>";
            ?>

        </tbody>
    </table>
</form>

<form action="<?php echo $PHP_SELF; ?>" id="targetForm" class="moderateForm" method="post" enctype="multipart/form-data" name="add_new_role_rule">
    <table class="widefat post">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Add/Edit New Rule</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="manage-column moderateSubmitCol"><input id="moderateSubmit" type="submit" value="Add/Edit"/></th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <select id="moderateTarget" name="target">
                    	<option id="targetValue" value="moderate-NO-TARGET">Select a Role...</option>
                        <?php
                        $roles = get_editable_roles();
                        foreach($roles as $role => $roleDetails){
                            echo '<option value="'.$role.'">'.$roleDetails['name'].'</option>';
                        }
                        ?>
                    </select>
                    <div class="taxonomydiv">
	                    <ul class="categorychecklist form-no-clear">
	                        <?php
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
	                    </ul>
	                </div>
                </td>
            </tr>
        </tbody>
        <!--input type="hidden" name="runMe" value="newRuleForRole" /-->
        <input type="hidden" name="runMe" value="editRuleForRole" />
</form>

<?php //include the footer file
include("template/footer.php");?>



















