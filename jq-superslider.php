<?php
/*
Plugin Name: jQ SuperSlider
Description: A simple but powerfull tool to make slideshows brought to you by RaverStudio in Merlin Toolkit 
Version: 1.0
Author: Mateo Torres
License:GPL2
*/

//crea la tabla en la base de datos... a donde se van las rutas de las imagenes de los thumbnails... y a donde linkea cada imagen


function install_jqsslider(){


/*
	echo "hola";
	global $wpdb;
	//crear la tabla
	$table_name = $wpdb->prefix . "jq-superslider";
	
	$myFile = "testFile.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "Bobby Bopper\n";
	fwrite($fh, $stringData);
	$stringData = "Tracy Tanner\n";
	fwrite($fh, $stringData);
	fclose($fh);
	
//	$sql = "CREATE TABLE IF NOT EXISTS $table_name(
//						id int(5) NOT NULL AUTO_INCREMENT,
//						post_id int(11) NOT NULL,
//						pic_path text default NULL,
//						link_url text default NULL,
//						UNIQUE KEY id(id)
//					);";
					
	$wpdb->query($sql);
	
	 if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time bigint(11) DEFAULT '0' NOT NULL,
		  name tinytext NOT NULL,
		  text text NOT NULL,
		  url VARCHAR(55) NOT NULL,
		  UNIQUE KEY id (id)
		);";
		
		
		$rs = $wpdb->query($sql);
	}
	$welcome_name = "Mr. Wordpress";
	$welcome_text = "Congratulations, you just completed the installation!";

	$rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
	
	echo "asf";
	
*/


global $wpdb, $table_prefix;
	$table_name = $table_prefix.'jq_superslider';
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time bigint(11) DEFAULT '0' NOT NULL,
		  name tinytext NOT NULL,
		  text text NOT NULL,
		  url VARCHAR(55) NOT NULL,
		  UNIQUE KEY id (id)
		);";
		$rs = $wpdb->query($sql);
	}

}

//add_action('activate_jq-superslider/pagina_del_plugin.php','install_jqsslider');

register_activation_hook( 'jq-superslider\jq-superslider.php', 'install_jqsslider' );


//funcion que agrega el css del slider
function css_text_insert(){
$link_al_css = '<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('url').'/wp-content/plugins/jq-superslider/superslider.css" />
';
 echo $link_al_css;

}


//funcion que agrega el link al jquery
function jquery_text_insert(){
$link_al_jquery = '<script src="'.get_bloginfo('url').'/wp-content/plugins/jq-superslider/jquery.js" type="text/javascript"></script>
';
$link_al_jquery .= '<script src="'.get_bloginfo('url').'/wp-content/plugins/jq-superslider/superslider.js" type="text/javascript"></script>
';

 echo $link_al_jquery;
}

//añadimos las funciones al head de la pagina
add_action('wp_head', 'css_text_insert');
add_action('wp_head', 'jquery_text_insert');
add_action('admin_head', 'css_text_insert');//agrega el css al admin page



//inserta el espacio html del slideshow (esta funcion se carga desde el index.php del template de wordpress)
function insert_slider(){

$slider_div = 
'<div id="slideshow">
	<div id="slidesContainer">
		<div class="slide">
			<a href=nkcjnsd><img src="wp-content/plugins/jq-superslider/keys.jpg" class="banner_pic"/></a>
		</div>
		<div class="slide">
			<img src="wp-content/plugins/jq-superslider/ruby.jpg" class="banner_pic"/>
		</div>
		<div class="slide">
			hola.... como andamos'.get_option('css').'
			akdnasdlkcnasdc
			asdckaldamsdc
			ckañmdkcl
		</div>
		<div class="slide">
			<img src="wp-content/plugins/jq-superslider/ruby.jpg" class="banner_pic"/>
		</div>
	</div>
</div>';

$slider = $slider_div;

echo $slider;
}


//------------------------------------------------------------------------//
//
//                       ADMIN MENU
// esta seccion añade los menúes en el panel de 
// administración de wordpress
//------------------------------------------------------------------------//

//Crea el menu del Toolkit 
//agregar a la siguiente version los temas para agregar desde el submenu del toolkit cada plugin... separar la carpeta del plugin de cada plugin por separado
function merlin_toolkit_menu() {

	add_menu_page('Merlin - RaverToolkit', 'Merlin Toolkit', 'manage_options', 'merlin-raver-toolkit-main-menu', 'merlin_plugin_options',get_bloginfo('url').'/wp-content/plugins/jq-superslider/icono.jpg',4);
	add_submenu_page( 'merlin-raver-toolkit-main-menu', 'jQ SuperSlidert', 'jQ SuperSlider', 'manage_options', 'jq-superslider-menupage', 'jq_superslider_options');
}

//añade el menu de administración de jQ SuperSlider
function jq_superslider_options(){

	if(isset($_POST["username"])){
		echo "hola dios mio esto anda hijo de puta".$_POST["username"];
		//aca trabajar con la base de datos
	}

	?>
	<div class="wrap">
		<div id="jqsslider_icon"></div>
		<h2>jQ SuperSlider</h2>
			
				<br>
				
				<p><h3>Slides Properties</h3></p>
				<p>Width <input name="slider-width" type="text" id="slider-width" />
				Height <input name="slider-height" type="text" id="slider-height" /></p>
				<p>Transition Delay <input name="slider-seconds" type="text" id="slider-seconds" /><i> time for automatic transition in seconds</i></p>
				<hr>
				<h3>Controls Location Style</h3>
				
				<label class="label_radio">
					<input name="sample-radio" value="1" type="radio" /><img src="<?php echo get_bloginfo('url').'/wp-content/plugins/jq-superslider/';?>controls_1.png">
				</label>
				<br>
				<label class="label_radio">
					<input name="sample-radio" value="1" type="radio" /><img src="<?php echo get_bloginfo('url').'/wp-content/plugins/jq-superslider/';?>controls_2.png">
				</label>
				<br>
				<label class="label_radio">
					<input name="sample-radio" value="1" type="radio" /><img src="<?php echo get_bloginfo('url').'/wp-content/plugins/jq-superslider/';?>controls_3.png">
				</label>
				<br>
				<label class="label_radio">
					<input name="sample-radio" value="1" type="radio" /><img src="<?php echo get_bloginfo('url').'/wp-content/plugins/jq-superslider/';?>controls_4.png">
				</label>
				<p><i>If you want further customization for controls, you can edit the superslider.css file, <br>
				it's well commented and should be an easy task if you know what you are doing</i></p>
				<input name="form" type="hidden" id="form" value="true"><br>
				<hr>
				
			
	</div>

<?php	
}




function merlin_plugin_options() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	echo '<div class="wrap">';
	echo '<p>Super menu para agregar los plugins del Toolkit</p>';
	echo '</div>';

}


add_action('admin_menu', 'merlin_toolkit_menu');

?>
