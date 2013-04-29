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
	
	//UTILS
	//TODO collect all 'utilites' functions and wrap then in a single class
	private function getUserRole(){
		global $current_user;
		
		$userRoles = $current_user->roles;
		$userRole = array_shift($userRoles);
		
		return $userRole;
	}


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
		if (!empty($roleRules))
			foreach ($roleRules as $key => $rule) 
				$formattedRules[$rule->role][] = $rule->category;
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
		$userRules = $wpdb->get_results($sql);
		$formattedRules = array();
		if (!empty($userRules))
			foreach ($userRules as $key => $rule)
				$formattedRules[$rule->user][] = $rule->category;
		return $formattedRules;
	}

	/**
	 * Gets the user-category entries from database for the specified user
	 * @return array configuration table
	 * @author Mateo Torres <torresmateo@arsisteam.com>
	 */
	public function getCategoriesForUser($userId){
		global $wpdb, $table_prefix;

		$sqlUserRules = 'select * from '.$table_prefix.'moderate_users where user = '.$userId;
		$sqlRoleRules = 'select * from '.$table_prefix.'moderate_roles where role ="'.$this->getUserRole($userId).'"';

		$userRulesOBJ = $wpdb->get_results($sqlUserRules);
		$roleRulesOBJ = $wpdb->get_results($sqlRoleRules);

		$userRulesArray = array();
		if(!empty($userRulesOBJ))
			foreach ($userRulesOBJ as $key => $rule)
				$userRulesArray[] = $rule->category;
		
		$roleRulesArray = array();
		if(!empty($roleRulesOBJ))
			foreach ($roleRulesOBJ as $key => $rule)
				$roleRulesArray[] = $rule->category;
		
		return array_unique(array_merge($userRulesArray, $roleRulesArray));
	}
}
?>