<?php

/*
Plugin Name: Dave's WordPress Live Search
Plugin URI: http://code.google.com/p/daves-wordpress-live-search/
Description: Adds "live search" functionality to your WordPress? site. Uses the built-in search and jQuery.
Version: 1.0
Author: Dave Ross
Author URI: http://csixty4.com/
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
 
add_action('init', 'DavesWordPressLiveSearch::advanced_search_init');

class DavesWordPressLiveSearch
{
	public static function advanced_search_init()
	{
		$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_dimensions', $pluginPath.'jquery.dimensions.pack.js', 'jquery');
		wp_enqueue_script('daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search.js.php', 'jquery_dimensions');
		
		wp_enqueue_style( 'daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search.css');
	}
}
?>