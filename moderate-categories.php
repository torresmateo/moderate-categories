<?php
/*
Plugin Name: Moderate Categories
Description: Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way
Version: 1.0
Author: Mateo Torres
Author URI: https://github.com/torresmateo/moderate-categories
License:GPL3
*/

class ModerateCategories{

    
    //============================================================================================================================
    //                          INSTALL/UNINSTALL
    //============================================================================================================================

    function __construct(){
        include_once('interface-builder.php');
        register_activation_hook(__FILE__, array($this,'install'));
        register_deactivation_hook(__FILE__, array($this, 'uninstall'));
        //adds the configuration menu to the dashboard
        add_action('admin_menu', array($this,'adminMenu'));
    }

    function install(){
        $fp = fopen("test.txt","w");
        fwrite($fp,"on install function\n");
        //TODO generates database structure
        fclose($fp);
    }

    static function uninstall(){
        //TODO uninstall script
    }

    
    //============================================================================================================================
    //                             ADMINISTRATOR GUI
    //============================================================================================================================


    //Adds the "Moderate Categories" menu to the admin dashboard
    public function adminMenu(){
        add_menu_page(  'Moderate Categories',
                        'Mod Categories',
                        'manage_options',
                        'moderate-by-categories',
                        array($this,'mainMenu'),
                        plugin_dir_url(__FILE__).'/top.logo.png');
    }

    //prints the AWSUM config screen (role-categories screen)
    public function mainMenu(){
        if (!current_user_can('manage_options'))  {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }
        $configMenu = new InterfaceBuilder('mainMenu');
        $configMenu->build();
    }

}

$moderateCategories = new ModerateCategories();
?>
