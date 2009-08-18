<?php

/*
Plugin Name: Dave's WordPress Live Search
Description: Adds "live search" functionality to your WordPress? site. Uses the built-in search and jQuery.
Version: 1.6
Author: Dave Ross
Author URI: http://davidmichaelross.com/
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
add_action('admin_notices', array('DavesWordPressLiveSearch', 'admin_notices'));

if(5.0 > floatval(phpversion()))
	die("Dave's WordPress Live Search requires PHP 5.0 or higher");

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

include_once("DavesWordPressLiveSearch.php");
?>