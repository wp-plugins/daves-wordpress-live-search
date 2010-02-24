<?php

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
