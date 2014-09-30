<!-- Main Menu Template

Shows the user-category rules table and the "Add Rule" button

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
$postTypeRules = $configAccess->getPostTypeConfiguration();
?>

<form action="<?php echo $PHP_SELF; ?>" id="targetForm" class="moderateForm" method="post" enctype="multipart/form-data" name="add_new_role_rule">
    <table class="widefat post">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Moderated Post Types</th>
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
					<div class="taxonomydiv">
						<?php $post_types = get_post_types('', 'object');

							echo "<pre>";
							//var_dump($post_types);
							echo "</pre>";

						?>
						<ul class="categorychecklist form-no-clear">
							<?php
								foreach ($post_types as $key => $post_type) {
									?>
									<li>
										<input type="checkbox" value="<?php echo $key;?>" name="rule[]" <?php if(in_array($key, $postTypeRules)) echo "checked";?>><?php echo $post_type->label;?>
									</li>
									<?php
								}
							?>
						</ul>
					</div>
				</td>
			</tr>
		</tbody>
		<input type="hidden" name="runMe" value="editPostType" />
		<input type="hidden" name="target" value="post_type" />
</form>

<?php //include the footer file
include("template/footer.php");?>



















