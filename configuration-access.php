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

class ConfigurationAccess{
	
	/**
	 * Gets the role-category entries from database
	 * @return array configuration table
	 * @author Mateo Torres <torresmateo@arsisteam.com>
	 */
	public function getRolesConfiguration(){
		global $wpdb, $table_prefix;
		$sql = 'select * from '.$table_prefix.'moderate_roles';
		$roleRules = $wpdb->get_results($sql);
		$formattedRules = array();
		foreach ($roleRules as $key => $rule) {
			$formattedRules[$rule->role][] = $rule->category;
		}
		return $formattedRules;
	}

	/**
	 * Gets the user-category entries from database
	 * @return array configuration table
	 * @author Mateo Torres <torresmateo@arsisteam.com>
	 */
	public function getUsersConfiguration(){
		global $wpdb, $table_prefix;
		$sql = 'select * from '.$table_prefix.'moderate_users';
		return $wpdb->get_results($sql);
	}
}
?>