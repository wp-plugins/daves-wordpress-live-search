<?php

$wpDir = realpath("../../../");
define('ABSPATH', $wpDir.'/');
if(file_exists($wpDir.'/wp-config.php') ) {
	include_once($wpDir.'/wp-config.php' );
} else {
	// "Since Version 2.6, you can move the wp-content directory, which holds your themes, plugins, and uploads, outside of the WordPress application directory."
	// @see http://codex.wordpress.org/Editing_wp-config.php#Moving_wp-content
	$parentDir = realpath("{$wpDir}/..");
	if(file_exists($parentDir.'/wp-config.php') && !file_exists($parentDir.'/wp-settings.php')) {
		include_once($parentDir.'/wp-config.php');
	}
	else {
		// Not sure what to do here. We couldn't find wp-config.php, so we don't
		// have a WordPress environment to report errors through. Let's just display
		// a nice message with a plain old echo statement.
		echo "Error loading wp-config.php";
	}
	unset($parentDir);
}
unset($wpDir);
