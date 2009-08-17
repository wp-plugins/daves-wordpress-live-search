<?php
class DavesWordPressLiveSearch
{
	///////////////////
	// Initialization
	///////////////////
	
	/**
	 * Initialize the live search object & enqueuing scripts
	 * @return void
	 */
	public static function advanced_search_init()
	{
		$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_dimensions', $pluginPath.'jquery.dimensions.pack.js', 'jquery');
	}
	
	/**
	 * Output the plugin's CSS & Javascript into the page's <head>
	 * @return void 
	 */
	public static function head()
	{		
		$thisPluginsDirectory = dirname(__FILE__);
		
		// $pluginPath is used in the Javascript
		$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		
		include($thisPluginsDirectory.'/daves-wordpress-live-search_default_gray.css.tpl');
		include($thisPluginsDirectory.'/daves-wordpress-live-search.js.php');
	}
	
	///////////////
	// Admin Pages
	///////////////
	
	/**
	 * Include the Live Search options page in the admin menu
	 * @return void
	 */
	public function admin_menu()
	{
		add_options_page("Dave's WordPress Live Search Options", __('Live Search', 'mt_trans_domain'), 8, __FILE__, array('DavesWordPressLiveSearch', 'plugin_options'));	
	}
	
	/**
	 * Display & process the Live Search admin options
	 * @return void
	 */
	public function plugin_options()
	{
		$thisPluginsDirectory = dirname(__FILE__);
		
		if("Save Changes" == $_POST['daves-wordpress-live-search_submit'])
		{
			// Read their posted value
	        $maxResults = max(intval($_POST['daves-wordpress-live-search_max_results']), 0);
	        $resultsDirection = $_POST['daves-wordpress-live-search_results_direction'];
	        $displayPostMeta = ("true" == $_POST['daves-wordpress-live-search_display_post_meta']);

	        // Save the posted value in the database
	        update_option('daves-wordpress-live-search_max_results', $maxResults );	
	        update_option('daves-wordpress-live-search_results_direction', $resultsDirection);
	        update_option('daves-wordpress-live-search_display_post_meta', (string)$displayPostMeta);
	        
	        // Translate the "Options saved" message...just in case.
	        // You know...the code I was copying for this does it, thought it might be a good idea to leave it
	        $updateMessage = __('Options saved.', 'mt_trans_domain' );
	        
	        echo "<div class=\"updated\"><p><strong>$updateMessage</strong></p></div>";
		}
		else
		{
			$maxResults = intval(get_option('daves-wordpress-live-search_max_results'));
			$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));
			$displayPostMeta = (bool)get_option('daves-wordpress-live-search_display_post_meta');
		}
	        
	    if(!in_array($resultsDirection, array('up', 'down')))
	        	$resultsDirection = 'down';
	        		
		include("$thisPluginsDirectory/daves-wordpress-live-search-admin.tpl");
	}
}
?>