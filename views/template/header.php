<?php
/**
 * Template for Moderate Categories
 * Header
 * @author Mateo Torres <torresmateo@arsisteam.com>
 */


//determine the active tab
if(isset($_GET['tab']) && in_array($_GET['tab'],array('1','2')))
    $tab = $_GET['tab']
    


?>

<div class="wrap">
    <h2 style="border-bottom: 1px solid #CCC; padding-bottom: 0px; white-space: nowrap;">
        <div id="moderate-categories-icon"></div>
        <br/>
        <a href="<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=moderate-categories'?>"  class="nav-tab <?php if(!$tab) echo "nav-tab-active";?>">Role-Category Rules</a>
        <a href="<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=moderate-categories&tab=1'?>" class="nav-tab <?php if($tab == 1) echo "nav-tab-active";?>">User-Category Rules</a>
        <a href="<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=moderate-categories&tab=2'?>" class="nav-tab <?php if($tab == 2) echo "nav-tab-active";?>">README</a>
    </h2>
