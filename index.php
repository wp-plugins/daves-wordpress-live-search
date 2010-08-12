<?php


include("../../../wp-config.php");

$siteURL = get_bloginfo('siteurl');
if(empty($siteURL))
{
	// siteurl is deprecated, so this is just covering my bases
	$siteURL = get_bloginfo('url');
}

wp_redirect($siteURL, 301);

?>
