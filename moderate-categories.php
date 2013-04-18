<?php
/*
Plugin Name: Moderate Categories
Description: Gives the WordPress admin the ability to give visibility access to roles and users for posts in a by-category way
Version: 1.0
Author: Mateo Torres
Author URI: https://github.com/torresmateo/moderate-categories
License:GPL3
*/

class ModerateCategories(){
    function __construct(){
        include_once('interface-builder.php');
    }
    static function install(){
        //TODO install script
    }

    static function uninstall(){
        //TODO uninstall script
    }

    //Adds the "Moderate Categories" menu to the admin dashboard
    function adminMenu(){
        add_menu_page('Moderate Categories','Moderate Categories','manage_options','moderate-by-categories.php',array($this,'mainMenu'),plugin_dir_url(__FILE__).'/top.logo.png');
        //TODO add configuration menu to the dashboard
    }

    //prints the AWSUM config screen
    function mainMenu(){
        $configMenu = new InterfaceBuilder('mainMenu');
        $configMenu->build();
    }

}

$moderateCategories = new ModerateCategories();
?>
