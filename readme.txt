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

== Known Issues ==

1. There must only be one search box per page. If there is more than one search box, the plugin gets confused. This may be fixed in a future release.
1. In the HTML, your search box must be named "s". This is the name the standard search widget uses, so this is only an issue for themers who include their own search box.
1. This plugin will not work on PHP 4.x
