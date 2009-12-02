=== Plugin Name ===
Contributors: csixty4
Donate link: http://catguardians.org
Tags: search, AJAX
Requires at least: 2.0
Tested up to: 2.8.5
Stable tag: 1.8
 
Adds "live search" functionality to your WordPress site. Uses the built-in search and jQuery.

== Description ==

Dave's WordPress Live Search adds "live search" functionality to your WordPress site. As visitors type words into your WordPress site's search box, the plugin continually queries WordPress, looking for search results that match what the user has typed so far.

The [live search](http://ajaxpatterns.org/Live_Search) technique means that most people will find the results they are looking for before they finish typing their query, and it saves them the step of having to click a submit button to get their search results.

This functionality requires Javascript, but the search box still works normally if Javascript is not available.

This plugin has been tested with WordPress 2.9, and will support WordPress 2.9's "post thumbnail" feature in the next release.

== Installation ==

1. Upload the `daves-wordpress-live-search` directory to your site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure it! Go to the 'Settings' menu and pick 'Live Search'. Here, you'll find options to control the look of your search results. By default, they're pretty plain, but you can change the color scheme or even tell it to display an excerpt of each post.

== Screenshots ==

1. Demonstration of Dave's WordPress Live Search

== Frequently Asked Questions ==

I don't get asked a lot of questions about this plugin, so here's the "known issues":

1. There must only be one search box per page. If there is more than one search box, the plugin gets confused. This may be fixed in a future release.
1. In the HTML, your search box must be named "s". This is the name the standard search widget uses, so this is only an issue for themers who include their own search box.
1. This plugin will not work on PHP 4.x

== Wish List ==

Features I want to implement in future releases:

1. Modify the CSS directly on the admin screen (so it's not tied to a theme).

== Changelog ==

=v1.8=
* 2009-10-25 Dave Ross <dave@csixty4.com>
* Added note about WP-Minify
* Tested with WordPress 2.8.5
* Moved JavaScript to an external file
* Security - nonce checking on admin screen
* Security - check "manage_options" security setting
* Notes on configuration in readme.txt

=v1.7=
* 2009-08-27 Dave Ross <dave@csixty4.com>
* Thumbnails in the search results
* Excerpts in the search results

=v1.6=
* 2009-08-17 Dave Ross <dave@csixty4.com>
* Implemented selectable CSS files
* Fixed a bug that broke live searches containing ' characters

=v1.5=
* 2009-07-08 Dave Ross  <dave@csixty4.com>
* Fixed compatibility with Search Everything plugin, possibly others

=v1.4=
* 2009-06-03 Dave Ross  <dave@csixty4.com>
* Renamed release 1.3.1 to 1.4 because WordPress.org doesn't seem to like 1.3.1. Seems like kind of a waste to do a full point release for this
* Building permalinks instead of using post guid (problem with posts imported from another blog)

=v1.3=
* 2009-05-22  Dave Ross  <dave@csixty4.com>   
* Fixed an annoying bug where the search results div collapsed and expanded again every time an AJAX request completed
* Cancel any existing AJAX requests before sending a new one
* Check for PHP 5.x. Displays an error when you try to activate the plugin on PHP < 5   
* No longer sends the entire WP_Query object to the browser. This was a potential information disclosure issue, plus it was a lot to serialize on the server and parse in the brower
* Minor code cleanup & optimizations
     
=v1.2=
* 2009-04-10  Dave Ross  <dave@csixty4.com>
* Code cleanup & optimizations 
* Styled the admin screen to fit in with WordPress better 
* New option: display the results above or below the search box 
* Included a note on the admin screen recommending the Google Libraries plugin
	 
=v1.1=
* 2009-03-30  Dave Ross  <dave@csixty4.com>
* Code cleanup & optimizations
* Fixed compatibility issues with PHP < 5.2.0 and PHP < 5.1.2
* New option: limit the number of results to display
	 
=v1.0=
* 2009-03-13  Dave Ross  <dave@csixty4.com>
* Initial release