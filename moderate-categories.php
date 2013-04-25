<?php
/*
Plugin Name: Moderate Categories
Description: Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way
Version: 1.0
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

    
    //============================================================================================================================
    //                          INSTALL/UNINSTALL
    //============================================================================================================================

    function __construct(){
        include_once('interface-builder.php');
        include_once('configuration-access.php');
        include_once('input-handler.php');
        register_activation_hook(__FILE__, array($this,'install'));
        register_deactivation_hook(__FILE__, array($this, 'uninstall'));
        //adds the css files for "pretty-ness"
        add_action('admin_head', array($this,'adminCSS'));
        //adds the js files for "awsum-ness"
        add_action('admin_head', array($this,'adminJS'));
        //adds the configuration menu to the dashboard
        add_action('admin_menu', array($this,'adminMenu'));
        $this->evalInput();
    }

    function install(){
        $this->createTables();
    }

    function uninstall(){
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
    //                             INPUT HANDLER
    //============================================================================================================================
    
    function evalInput(){
        if(isset($_POST['runMe']) && isset($_POST['target']) && isset($_POST['rule'])){
            $inputHandler = new InputHandler($_POST['runMe'],$_POST['target'],$_POST['rule']);
        }
    }

    //============================================================================================================================
    //                             ADMINISTRATOR GUI
    //============================================================================================================================
    
    //outputs the CSS link
    public function adminCSS(){
        echo '<link rel="stylesheet" type="text/css" media="screen" href="'.plugin_dir_url(__FILE__).'/views/template/css/style.css" />';
    }

    //outputs the JavaScript link
    public function adminJS(){
		echo '<script type="text/javascript"> if (window.jQuery == undefined) document.write( unescape(\'%3Cscript src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"%3E%3C/script%3E\') );</script>';
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
        if(isset($_GET['tab'])){
            switch($_GET['tab']){
                case '1': $target = 'userMenu'; break;
                case '2': $target = 'how-to-Page'; break;
                default: $target = 'error'; //because redundancy is never really redundant!
            }
        }else{//if not set, must be mainMenu
            $target = 'mainMenu';
        }
        $configMenu = new InterfaceBuilder($target);
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
