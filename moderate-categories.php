<?php
/*
Plugin Name: Moderate Categories
Description: Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way
Version: 1.0.1
Author: Mateo Torres
Author URI: https://github.com/torresmateo/moderate-categories
License:GPL3
*/

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

class ModerateCategories{

	//for use in filtering to avid infinite recursive loops
	private $allCatsArray;
	//for category edition
	private $finalSet;

	//============================================================================================================================
	//						  INSTALL/UNINSTALL
	//============================================================================================================================

	function __construct(){
		$this->allCatsArray = get_all_category_ids();
		//interface handler
		include_once('interface-builder.php');
		//database access for configuration retrieval
		include_once('configuration-access.php');
		//input handler, and database acces for insertions, deletions and modifications
		include_once('input-handler.php');
		//activation and deactivation hooks
		register_activation_hook(__FILE__, array($this,'install'));
		register_deactivation_hook(__FILE__, array($this, 'uninstall'));
		
		//interface actions

		//adds the css files for "pretty-ness"
		add_action('admin_head', array($this,'adminCSS'));
		//adds the js files for "awsum-ness"
		add_action('admin_head', array($this,'adminJS'));
		//adds the configuration menu to the dashboard
		add_action('admin_menu', array($this,'adminMenu'));
		
		//restriction actions

		//adds the edition screen restrictions
		add_action('pre_get_posts', array($this,'restrictEditScreen'));
		//adds the edition screen restrictions
		add_action('load-post.php', array($this,'restrictPostEdition'));
		//adds the category filter for widgets, metaboxes and other admin places
		add_action('list_terms_exclusions', array($this,'filterCategories'));

		//restriction filters

		//users cannot modify post categories other than those in configuration
		add_filter('wp_insert_post_data',array($this,'disableCategoryUpdate'), '99', 2);
	
		
		$this->evalInput();
	}

	function install(){
		//create database
		$this->createTables();
	}

	function uninstall(){
		//erase database
		$this->dropTables();
	}

	function createTables(){
		global $wpdb, $table_prefix;
		//create roles table
		$tableName = $table_prefix . "moderate_roles";
		if($wpdb->get_var("show tables like '$tableName'") != $tableName){
			$sql = "create table $tableName (
						id int NOT NULL AUTO_INCREMENT,
						role varchar(50) NOT NULL,
						category int NOT NULL,
						UNIQUE KEY id(id)
					);";
			$rs = $wpdb->query($sql);
		}

		//create users table
		$tableName = $table_prefix . "moderate_users";
		if($wpdb->get_var("show tables like '$tableName'") != $tableName){
			$sql = "create table $tableName (
						id int NOT NULL AUTO_INCREMENT,
						user int NOT NULL,
						category int NOT NULL,
						UNIQUE KEY id(id)
					);";
			$rs = $wpdb->query($sql);
		}
	}

	function dropTables(){
		global $wpdb, $table_prefix;
	
		//drop role table
		$table_name = $table_prefix.'moderate_roles';
		$sql = "DROP TABLE ". $table_name . ";";
		$wpdb->query($sql);

		//drop user table
		$table_name = $table_prefix.'moderate_users';
		$sql = "DROP TABLE ". $table_name . ";";
		$wpdb->query($sql);
	}
	
	//============================================================================================================================
	//							 RESTRICTION HOOKS
	//============================================================================================================================
	
	function restrictEditScreen( $wpQuery ){
		global $current_user,$pagenow;
		if ( $pagenow == 'edit.php' ){
			$configurationAccess = new ConfigurationAccess();
			$configuration = $configurationAccess->getCategoriesForUser($current_user->id);
			if(!empty($configuration)){
				$wpQuery->set('cat',implode(",",$configuration));
			}
		}
	}

	function restrictPostEdition(){
		global $current_user, $pagenow;
		
		$configurationAccess = new ConfigurationAccess();
		$configuration = $configurationAccess->getCategoriesForUser($current_user->id);
		
		if(!empty($configuration)){
			if(isset($_GET['post'])){
				$post = get_post($_GET['post']);
				$categories = wp_get_post_categories($post->ID);
				//give access if post is on at least one of the categories
				$allowed = false;
				foreach ($categories as $cat) 
					if(in_array($cat, $configuration)){
						$allowed = true;
						break;
					}
				if($allowed)
					return;
				wp_die(__('You are not allowed to access this part of the site'));
			}
		}
	}

	function filterCategories( $exclusions ){
		global $current_user, $pagenow;
		$configurationAccess = new ConfigurationAccess();
		$configuration = $configurationAccess->getCategoriesForUser($current_user->id);
		if ( in_array($pagenow, array('edit.php','post.php', 'post-new.php'))){
			$inclusion;
			foreach ($configuration as $key => $category) {
				$categoryParents = explode(',',get_category_parents($category, false, ',', true));
				foreach ($categoryParents as $key => $slug)
					if($slug != '')
						$inclusion .= get_category_by_slug($slug)->cat_ID.",";
			}
			//clean all trailing commas and duplicates
			$inclusionArray = array_filter(array_unique(explode(',', $inclusion)));
			$exclusionArray = array_diff($this->allCatsArray, $inclusionArray);
			$exclusion = implode(',', $exclusionArray);
			$inclusion = implode(',', $inclusionArray);
			$inclusion = implode(',', $configuration);
			if($inclusion != "")
				$exclusions .= "AND t.term_id IN ($inclusion)";
		}
		return $exclusions;
	}

	function disableCategoryUpdate($data, $postarr){
		global $current_user,$pagenow;
		$configurationAccess = new ConfigurationAccess();
		$configuration = $configurationAccess->getCategoriesForUser($current_user->id);
		//if user have at least one restriction we must verify
		
		if(!empty($configuration) && $postarr['post_type'] == 'post'){
			//get the (soon to be) old set of categories
			$currentCategories = wp_get_post_categories($postarr['ID']);
			//get the new set of categories
			$newCategories = $postarr['post_category'];
            if(!is_array($newCategories)) $newCategories = array();
			//categories that we can't see must remain
			$mustRemain = array_diff($currentCategories, $configuration);
			//add the new set of categories
			$finalSet = array_unique(array_merge($mustRemain,$newCategories));
			$this->finalSet = $finalSet;
			add_action('save_post',array($this,'setCategories'));
		}
		return $data;
	}

	function setCategories( $post_ID){
		wp_set_post_categories( $post_ID, $this->finalSet ) ;
	}

	//============================================================================================================================
	//							 INPUT HANDLER
	//============================================================================================================================
	
	function evalInput(){
		//if we have something to do, create and InputHandler Instance and do stuff
		if(isset($_POST['runMe']) && isset($_POST['target'])){
			$inputHandler = new InputHandler($_POST['runMe'],$_POST['target'],$_POST['rule']);
		}
	}

	//============================================================================================================================
	//							 ADMINISTRATOR GUI
	//============================================================================================================================
	
	//outputs the CSS link
	public function adminCSS(){
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.plugin_dir_url(__FILE__).'/views/template/css/style.css" />';
	}

	//outputs the JavaScript link
	public function adminJS(){
		//load jQuery
		echo '<script type="text/javascript"> if (window.jQuery == undefined) document.write( unescape(\'%3Cscript src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"%3E%3C/script%3E\') );</script>';
		//load the plugin script
		echo '<script type="text/javascript" src="'.plugin_dir_url(__FILE__).'/views/template/js/moderate-categories.js"></script>';
	}

	//Adds the "Moderate Categories" menu to the admin dashboard
	public function adminMenu(){
		add_menu_page(  'Moderate Categories',
						'Mod Categories',
						'manage_options',
						'moderate-categories',
						array($this,'mainMenu'),
						plugin_dir_url(__FILE__).'/views/template/img/top.logo.png');
	}

	//prints the AWSUM config screen (role-categories screen)
	public function mainMenu(){
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		$target = 'error';//default value is error page

		//if we are inside one of our tabs
		if(isset($_GET['tab'])){
			switch($_GET['tab']){
				case '1': $target = 'userMenu'; break;
				case '2': $target = 'how-to-Page'; break;
				default: $target = 'error'; //because redundancy is never really redundant enough!
			}
		}else{//if not set, must be mainMenu
			$target = 'mainMenu';
		}
		$configMenu = new InterfaceBuilder($target);

		//paint it!
		$configMenu->build();
	}

}

/**
 * Custom walker class to create a category checklist
 * 
 * Taken from "Restrict Cateogories Plug-in"
 * http://wordpress.org/support/plugin/restrict-categories
 * @since 1.5
 */
class RestrictCats_Walker_Category_Checklist extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

	function start_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $category, $depth, $args) {
		extract($args);
		if ( empty($taxonomy) )
			$taxonomy = 'category';

		if ( $taxonomy == 'category' )
			$name = 'post_category';
		else
			$name = 'tax_input['.$taxonomy.']';
		
		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'>" . '<label class="selectit"><input value="' . 
			$category->slug . '" type="checkbox" name="rule[]" ' . 
			checked( in_array( $category->slug, $selected_cats ), true, false ) . 
			( $disabled === true ? 'disabled="disabled"' : '' ) . ' /> ' . 
			esc_html( apply_filters('the_category', $category->name ) ) . '</label>';
	}

	function end_el(&$output, $category, $depth, $args) {
		$output .= "</li>\n";
	}
}



$moderateCategories = new ModerateCategories();
?>
