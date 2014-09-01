<?php
/*
Plugin Name: Fly Twitter on Blog
Plugin URI: http://www.gcodelabs.com/wp-plugin-fly-twitter-on-site.php
Description: This plugin gives the flying twitter bird on a blog, which refers to random HTML elements and always settles in the visible portion of the window remains.If you move the cursor over the bird, a "tweet-this" and "follow-me" link appears. From the admin settings, managed the display of latest tweets.
This plugin is based on the Javascript code developed by http://floern.com.For more details visit the <a href="http://www.gcodelabs.com/wp-plugin-fly-twitter-on-site.php">Twitter Bird Plugin / Support Page</a>
Author: gCodeLabs
Version: 1.1 
Author URI: http://profiles.wordpress.org/gcodelabs/
Donate URI: http://www.gcodelabs.com/wp-plugin-fly-twitter-on-site.php
*/
/*  Copyright 2012  gCodeLabs  (email : admin@gcodelabs.com)

    This program is free software; you can redistribute it and/or modify 
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software 
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA  
*/
function addTwiiterJs() {
	if ( !is_admin() ) { 
	//// this is section for the add the script code////
	echo("
	<!-- twitter follow by gcodelabs.com -->
		<script src=' ".get_bloginfo('wpurl').'/wp-content/plugins/fly-twitter-on-blog/js/twitter.js'."'; ' type='text/javascript'></script><script type='text/javascript' charset='utf-8'><!--
			var twitterAccount = '" . get_option("animated_account") . "';
			var showTweet = " . get_option("animated_tweet") . ";
			var birdSprite=' ".get_bloginfo('wpurl').'/wp-content/plugins/fly-twitter-on-blog/twitterbird.png'."';
			var twitterfeedreader=' ".get_bloginfo('wpurl').'/wp-content/plugins/fly-twitter-on-blog/twitterfeeds.php'."';
			tripleflapInit();
		--></script>
	<!-- end of twitter js code -->"); /// dont change this code 
}
}
function animated_menu() {
	add_options_page('Twitter Bird Options', 'Fly Twitter', 8, 'FlyTwitter', 'animated_options_page');
}

function animated_options_page() {
	echo '<div class="wrap">';
	echo '<h2>Fly Twitter Bird ' . __('Options', 'animated') . '</h2>';
	echo '<form method="post" action="options.php">';
	wp_nonce_field('update-options');
	echo '<table class="form-table" style="width: 530px;">';
	echo '<tr valign="top">';
	echo '<th scope="row">' . __('Twitter account', 'animated') . '</th>';
	echo '<td><input type="text" name="animated_account" value="' . get_option('animated_account') . '" /></td>';
	echo '</tr>';
	echo '<th scope="row">' . __('Display your Latest Tweet on Bird?', 'ATB') . '</th>';
	echo '<td><input type="radio" name="animated_tweet" value="true"'; 
	if(get_option('animated_tweet') == "true")
		echo ' checked';
	echo '/> ' . __('Yes', 'animated') . '</td>';
 	echo '<td><input type="radio" name="animated_tweet" value="false"'; 
	if(get_option('animated_tweet') == "false")
		echo ' checked';
	echo '/> ' . __('No', 'animated') . '</td>';
	echo '</tr>';
 	echo '</table>';
	echo '<p class="submit">';	
	echo '<input type="submit" class="button-primary" value="' . __('Save Changes') . '" />';
	echo '</p>';
 	settings_fields('AnimatedTwitterBird');
 	echo '</form>';
	echo '</div>';
 	echo '<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr><td><hr /></td></tr>
	<tr><td><strong>Check in Preview, How it look at Site</strong></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><iframe src="'.get_bloginfo('wpurl').'" height="700" width="800" scrolling="no" align="middle" /></iframe></td></tr>
	</table>';
	addTwiiterJs();
}

function animated_register_settings() {
	register_setting('AnimatedTwitterBird', 'animated_account');
	register_setting('AnimatedTwitterBird', 'animated_tweet');
	}

$plugin_dir = basename(dirname(__FILE__));

add_option("animated_account");
add_option("animated_tweet", "false");
add_action('wp_footer', 'addTwiiterJs');

if(is_admin()){
	add_action('admin_menu', 'animated_menu');
	add_action('admin_init', 'animated_register_settings');
}
//Add new setting options, redirect set
function twitter_setting_action_links($links, $file) {
    static $this_plugin;
     if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    if ($file == $this_plugin) {
        // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=FlyTwitter">Settings</a>';
        // add the link to the list
        array_unshift($links, $settings_link);
    }
     return $links;
}
add_filter('plugin_action_links', 'twitter_setting_action_links', 10, 2);
?>
