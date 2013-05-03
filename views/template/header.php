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
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display:inline-block;">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
    </h2>
