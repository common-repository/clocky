<?php
/*
	Plugin Name: Clocky - Flash Clock Widget
	Plugin URI: http://caliaccountant.com/clocky-wordpress-widget/
	Description: Clocky - THe Clock Time Widget provides you a way  to add a flash clock widget to your sidebars.  This plugin includes twenty-four assorted clocks. All clock are relatively small flash files and appear really sharp.  Nearly all work with any theme. 
	Version: 1
	Author: henryleyden
	Author URI: http://caliaccountant.com/clocky-wordpress-widget/
	

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function Clocky_widget_install () {
	$widgetoptions = get_option('Clocky_widget');
	$newoptions['width'] = '160';
	$newoptions['height'] = '160';
	$newoptions['FlashClock'] = '1';
	add_option('Clocky_widget', $newoptions);
}

function Clocky_widget_init($content){
	if( strpos($content, '[Clocky-Widget]') === false ){
		return $content;
	} else {
		$code = Clocky_widget_createflashcode(false);
		$content = str_replace( '[Clocky-Widget]', $code, $content );
		return $content;
	}
}

function Clocky_widget_insert(){
	echo Clocky_widget_createflashcode(false);
}

function Clocky_widget_createflashcode($widget){
	if( $widget != true ){
	} else {
		$options = get_option('Clocky_widget');
		$soname = "widget_so";
		$divname = "wpFlash_Clockwidgetcontent";
	}
	if( function_exists('plugins_url') ){ 
		$clocknum = $options['FlashClock'].".swf";
		$movie = plugins_url('clocky/flash/wp-clock-').$clocknum;
		$path = plugins_url('clocky/');
	} else {
		$clocknum = $options['FlashClock'].".swf";
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/clocky/flash/wp-clock-".$clocknum;
		$path = get_bloginfo('wpurl')."/wp-content/plugins/clocky/";
	}

	$flashtag = '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';	
	$flashtag .= '<center><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$options['width'].'" height="'.$options['height'].'" id="FlashTime" align="middle">';
	$flashtag .= '<param name="movie" value="'.$movie.'" /><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" />';
	$flashtag .= '<!--[if !IE]>--><object type="application/x-shockwave-flash" data="'.$movie.'" width="'.$options['width'].'" height="'.$options['height'].'" align="middle"><param name="menu" value="false" /><param name="wmode" value="transparent" /><param name="allowscriptaccess" value="always" /><!--<![endif]-->';
$flashtag .= '<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a> <a href="http://wordpress.org/extend/plugins/clocky/">Wordpress Plugin</a> By <a href="http://caliaccountant.com/">California Accountant</a><!--[if !IE]>--></object><!--<![endif]--></object></center>';
	return $flashtag;
}


function Clocky_widget_uninstall () {
	delete_option('Clocky_widget');
}


function widget_init_Clocky_widget_widget() {
	if (!function_exists('register_sidebar_widget'))
		return;

	function Clocky_widget_widget($args){
	    extract($args);
		$options = get_option('Clocky_widget');
		$title = empty($options['title']) ? __('Clocky: Clock Widget') : $options['title'];
		?>
	        <?php echo $before_widget; ?>	
				<?php echo $before_title . $title . $after_title;?>
				<?php 
					if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){
						echo Clocky_widget_createflashcode(true);
					}
				?>
								<span style="float:right;"><font size="1"><a target="_blank" title="More About this clock" href="http://caliaccountant.com/clocky-wordpress-widget/">?</a></font></span>
	        <?php echo $after_widget; ?>
		<?php
	}
	
	function Clocky_widget_widget_control() {
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/clocky/flash/wp-clock-";
		$path = get_bloginfo('wpurl')."/wp-content/plugins/clocky/";
		$options = $newoptions = get_option('Clocky_widget');
		if ( $_POST["Clocky_widget_submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["Clocky_widget_title"]));
			$newoptions['width'] = strip_tags(stripslashes($_POST["Clocky_widget_width"]));
			$newoptions['height'] = strip_tags(stripslashes($_POST["Clocky_widget_height"]));
			$newoptions['FlashClock'] = strip_tags(stripslashes($_POST["Clocky_widget_FlashClock"]));
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('Clocky_widget', $options);
		}
		$title = attribute_escape($options['title']);
		$width = attribute_escape($options['width']);
		$height = attribute_escape($options['height']);
		$FlashClock = attribute_escape($options['FlashClock']);
		?>
			<p><label for="Clocky_widget_title"><?php _e('Title:'); ?> <input class="widefat" id="Clocky_widget_title" name="Clocky_widget_title" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="Clocky_widget_width"><?php _e('Width:'); ?> <input class="widefat" id="Clocky_widget_width" name="Clocky_widget_width" type="text" value="<?php echo $width; ?>" /></label></p>
			<p><label for="Clocky_widget_height"><?php _e('Height:'); ?> <input class="widefat" id="Clocky_widget_height" name="Clocky_widget_height" type="text" value="<?php echo $height; ?>" /></label></p>
						<p><label for="Clocky_widget_FlashClock"><?php _e('Clock:'); ?></label></p>
			<? for ( $i = 1; $i <= 21; $i += 1) { ?>			
				<center>
				<input type="radio" name="Clocky_widget_FlashClock" value="<? echo $i ?>" <?php if ($FlashClock == $i) echo 'checked' ?>> 
				<object width="160" height="160" align="middle" id="FlashTime" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="
				<? echo $movie . $i ?>.swf" name="movie"/><param value="false" name="menu"/><param value="transparent" name="wmode"/><param value="always" name="allowscriptaccess"/><!--[if !IE]>--><object width="160" height="160" align="middle" data="<? echo $movie . $i ?>.swf" type="application/x-shockwave-flash"><param value="false" name="menu"/><param value="transparent" name="wmode"/><param value="always" name="allowscriptaccess"/><!--<![endif]--><!--[if !IE]>--></object><!--<![endif]--></object><br/></center>
			<? } ?> 
			
			<input type="hidden" id="Clocky_widget_submit" name="Clocky_widget_submit" value="1" />
		<?php
	}
	
	register_sidebar_widget( "Clocky: Clock Widget", Clocky_widget_widget );
	register_widget_control( "Clocky: Clock Widget", "Clocky_widget_widget_control" );
}

add_action('widgets_init', 'widget_init_Clocky_widget_widget');
add_filter('the_content','Clocky_widget_init');
register_activation_hook( __FILE__, 'Clocky_widget_install' );
register_deactivation_hook( __FILE__, 'Clocky_widget_uninstall' );
?>
