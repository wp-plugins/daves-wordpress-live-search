<?php
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