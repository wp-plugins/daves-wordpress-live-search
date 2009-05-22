=== Plugin Name ===
Contributors: csixty4
Donate link: http://catguardians.org
Tags: search, AJAX
Requires at least: 2.0
Tested up to: 2.7.1
Stable tag: 1.3

Adds "live search" functionality to your WordPress site. Uses the built-in search and jQuery.

== Description ==

Dave's WordPress Live Search adds "live search" functionality to your WordPress site. As visitors type words into your WordPress site's search box, the plugin continually queries WordPress, looking for search results that match what the user has typed so far.

The [live search](http://ajaxpatterns.org/Live_Search) technique means that most people will find the results they are looking for before they finish typing their query, and it saves them the step of having to click a submit button to get their search results.

This functionality requires Javascript, but the search box still works normally if Javascript is not available.

== Installation ==

1. Upload the `daves-wordpress-live-search` directory to your site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Demonstration of Dave's WordPress Live Search

== Frequently Asked Questions ==

I don't get asked a lot of questions about this plugin, so here's the "known issues":

1. There must only be one search box per page. If there is more than one search box, the plugin gets confused. This may be fixed in a future release.
1. In the HTML, your search box must be named "s". This is the name the standard search widget uses, so this is only an issue for themers who include their own search box.
1. This plugin will not work on PHP 4.x

== Changelog ==

v1.3 2009-05-22  Dave Ross  <dave@csixty4.com>
     
* Fixed an annoying bug where the search results div collapsed and expanded again every time an AJAX request completed
     
* Cancel any existing AJAX requests before sending a new one
     
* Check for PHP 5.x. Displays an error when you try to activate the plugin on PHP < 5
     
* No longer sends the entire WP_Query object to the browser. This was a potential information disclosure issue, plus it was a lot to serialize on the server and parse in the brower
     
* Minor code cleanup & optimizations
     
v1.2 2009-04-10  Dave Ross  <dave@csixty4.com>

* Code cleanup & optimizations
	 
* Styled the admin screen to fit in with WordPress better
	 
* New option: display the results above or below the search box
	 
* Included a note on the admin screen recommending the Google Libraries plugin
	 
v1.1 2009-03-30  Dave Ross  <dave@csixty4.com>

* Code cleanup & optimizations
	 
* Fixed compatibility issues with PHP < 5.2.0 and PHP < 5.1.2
	 
* New option: limit the number of results to display
	 
v1.0 2009-03-13  Dave Ross  <dave@csixty4.com>

* Initial release