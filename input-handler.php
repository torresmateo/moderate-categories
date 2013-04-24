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

class InputHandler{

	private $runMe = false;

	function __construct($input, $target, $rule){
		$this->runMe = $input;
		$this->handleInput($target, $rule);	
	}

	function handleInput($target, $rule){
		switch ($this->runMe) {
			case 'newRuleForRole':
				$this->newRuleForRole($target, $rule);
				break;
			case 'editRuleForRole':
				$this->editRuleForRole($target, $rule);
				break;
			case 'newRuleForUser':
				$this->newRuleForUser($target, $rule);
				break;
			case 'editRuleForUser':
				$this->editRuleForUser($target, $rule);
				break;
			default:
				//TODO handle error
				break;
		}
	}

	function newRuleForRole($role, $categoryArray){
		global $wpdb, $table_prefix;
		
		$sql = 'insert into '.$table_prefix.'moderate_roles (role, category) values ';
		$lastKey = array_search(end($categoryArray), $categoryArray);
		foreach ($categoryArray as $key => $category) {
			$id= get_category_by_slug($category)->cat_ID;
			$sql .= '("'.$role.'",'.$id.')';
			if($key != $lastKey)
				$sql .= ',';			
		}
		echo "$sql";
		var_dump($role);
//		var_dump($categoryArray);
	}

	function editRuleForRole($role, $categoryArray){
		//TODO update row on role category table
	}

	function newRuleForUser($user, $categoryArray){
		//TODO add row on user category table
		var_dump($user);
		var_dump($categoryArray);
	}

	function editRuleForUser($user, $categoryArray){
		//TODO update row on user category table
	}

}

?>