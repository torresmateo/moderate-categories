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
			case 'resetRole':
				$this->resetRole($target);
				break;
			case 'resetUser':
				$this->resetUser($target);
				break;
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

	function insertNewRule($table,$target,$categoryArray,$type){
		global $wpdb, $table_prefix;
		//in case all rules are duplicates.
		$haveRules = false;
		
		//begin sql statement
		$sql = 'insert into '.$table_prefix.$table.' ('.$type.', category) values ';
		
		foreach ($categoryArray as $key => $category) {

			//get the category id
			$id= get_category_by_slug($category)->cat_ID;

			//check for possible duplicate rules (shouldn't be necessary)
			$sqlCheckDuplicate = 'select * from '.$table_prefix.$table.' where '.$type.' = "'.$target.'" and category = '.$id.';';
			$duplicateCheck = $wpdb->get_results($sqlCheckDuplicate);
			//if the current rule is new is included in the query
			if(empty($duplicateCheck)){
				
				//if this isn't the firt rule, a comma must be added. 
				if($haveRules)
					$sql .= ',';		
				//we have at least one new rule
				$haveRules = true;
				//add rule
				$sql .= '("'.$target.'",'.$id.')';
			}	
		}
		//insert rules 
		if($haveRules)
			$wpdb->query($sql);
	}

	function editRule($table,$target,$categoryArray,$type){
		global $wpdb, $table_prefix;

		//get the current rule for target
		$sqlCurrentRule = 'select * from '.$table_prefix.$table.' where '.$type.' = "'.$target.'"';
		$currentRuleOBJ = $wpdb->get_results($sqlCurrentRule);
		
		$currentRule = array();
		foreach ($currentRuleOBJ as $ruleOBJ) {
			$currentRule[] = $ruleOBJ->category;
		}

		//get the new rule array (id)
		$newRule = array();
		if(!empty($categoryArray))
			foreach ($categoryArray as $key => $category)
				$newRule[] = get_category_by_slug($category)->cat_ID;
		
		//delete categories that are excluded from new rule
		$deleteCats = array_diff($currentRule, $newRule);
		if(!empty($deleteCats)){
			$sqlDelete = 'delete from '.$table_prefix.$table.' where '.$type.' = "'.$target.'" and category in (';
			
			reset($deleteCats);
			$firstKey = key($deleteCats);
			foreach ($deleteCats as $key => $oldCat){
				if($key != $firstKey)
					$sqlDelete .= ',';
				$sqlDelete .= $oldCat;
			}
			$sqlDelete .= ")"; 
			$wpdb->query($sqlDelete);
		}
		$insertCats = array_diff($newRule, $currentRule);
		
		if(!empty($insertCats)){
			$insertCatsSlugs = array();
			foreach ($insertCats as $catID) {
				$insertCatsSlugs[] = get_category($catID)->slug;
			}
			$this->insertNewRule($table,$target,$insertCatsSlugs,$type);
		}
	}


	function newRuleForRole($role, $categoryArray){
		$this->insertNewRule('moderate_roles',$role,$categoryArray,'role');
	}

	function editRuleForRole($role, $categoryArray){
		$this->editRule('moderate_roles',$role,$categoryArray,'role');
	}

	function newRuleForUser($user, $categoryArray){
		$this->insertNewRule('moderate_users',$role,$categoryArray,'user');
	}

	function editRuleForUser($user, $categoryArray){
		$this->editRule('moderate_users',$user,$categoryArray,'user');
	}

	function resetRole($role){
		global $wpdb, $table_prefix;
		$sql = 'delete from '.$table_prefix.'moderate_roles where role = "'.$role.'"';
		echo "$sql";
		$wpdb->query($sql);
	}

	function resetUser($user){
		global $wpdb, $table_prefix;
		$sql = 'delete from '.$table_prefix.'moderate_users where user = "'.$user.'"';
		$wpdb->query($sql);
	}

}

?>