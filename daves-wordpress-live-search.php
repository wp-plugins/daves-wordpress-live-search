<?php

/*
Plugin Name: Dave's WordPress Live Search
Description: Adds "live search" functionality to your WordPress? site. Uses the built-in search and jQuery.
Version: 1.3
Author: Dave Ross
Author URI: http://csixty4.com/
Plugin URI: http://wordpress.org/extend/plugins/daves-wordpress-live-search/
*/

/**
 * Copyright (c) 2009 Dave Ross <dave@csixty4.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 * persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR 
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR 
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/
 
// Register hooks
add_action('init', array('DavesWordPressLiveSearch', 'advanced_search_init'));
add_action('admin_menu', array('DavesWordPressLiveSearch', 'admin_menu'));
add_action('wp_head', array('DavesWordPressLiveSearch', 'head'));

// Pre-2.6 compatibility
// See http://codex.wordpress.org/Determining_Plugin_and_Content_Directories
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

class DavesWordPressLiveSearch
{
	///////////////////
	// Initialization
	///////////////////
	
	public static function advanced_search_init()
	{
		$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_dimensions', $pluginPath.'jquery.dimensions.pack.js', 'jquery');
	}
	
	public static function head()
	{
		$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));		
		$thisPluginsDirectory = dirname(__FILE__);
		
		//$css = file_get_contents($thisPluginsDirectory.'/daves-wordpress-live-search.css.tpl');
		//$css = str_replace("\n", "", $css);
		//echo $css;
		include($thisPluginsDirectory.'/daves-wordpress-live-search.css.tpl');

		include($thisPluginsDirectory.'/daves-wordpress-live-search.js.php');
		
	}
	
	///////////////
	// Admin Pages
	///////////////
	
	public function admin_menu()
	{
		add_options_page("Dave's WordPress Live Search Options", "Live Search", 8, __FILE__, array('DavesWordPressLiveSearch', 'plugin_options'));	
	}
	
	public function plugin_options()
	{
		$thisPluginsDirectory = dirname(__FILE__);
		
		if($_POST['daves-wordpress-live-search_submit'] == "Save Changes")
		{
			// Read their posted value
	        $maxResults = max(intval($_POST['daves-wordpress-live-search_max_results']), 0);
	        $resultsDirection = $_POST['daves-wordpress-live-search_results_direction'];

	        // Save the posted value in the database
	        update_option('daves-wordpress-live-search_max_results', $maxResults );	
	        update_option('daves-wordpress-live-search_results_direction', $resultsDirection);
	        
	        // Translate the "Options saved" message...just in case.
	        // You know...the code I was copying for this does it, thought it might be a good idea to leave it
	        $updateMessage = __('Options saved.', 'mt_trans_domain' );
	        
	        echo "<div class=\"updated\"><p><strong>$updateMessage</strong></p></div>";
		}
		else
		{
			$maxResults = intval(get_option('daves-wordpress-live-search_max_results'));
			$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));
		}
	        
	    if(!in_array($resultsDirection, array('up', 'down')))
	        	$resultsDirection = 'down';
	        		
		include("$thisPluginsDirectory/daves-wordpress-live-search-admin.tpl");
	}
}
?>