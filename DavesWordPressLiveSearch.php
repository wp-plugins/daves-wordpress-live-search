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
		if(self::isSearchablePage()) {
			$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery_dimensions', $pluginPath.'jquery.dimensions.pack.js', 'jquery');
			wp_enqueue_script('daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search.js.php', 'jquery_dimensions');
				
			$cssOption = get_option('daves-wordpress-live-search_css_option');

			$themeDir = get_bloginfo("template_url");
		
			switch($cssOption)
			{
				case 'theme':
					wp_enqueue_style('daves-wordpress-live-search', $themeDir.'/daves-wordpress-live-search.css');
					break;
				case 'default_red':
					wp_enqueue_style('daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search_default_red.css');
					break;
				case 'default_blue':
					wp_enqueue_style('daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search_default_blue.css');
					break;				
				case 'default_gray':
				default:
					wp_enqueue_style('daves-wordpress-live-search', $pluginPath.'daves-wordpress-live-search_default_gray.css');
			}		
		}
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
		if(current_user_can('manage_options'))
		{
			add_options_page("Dave's WordPress Live Search Options", __('Live Search', 'mt_trans_domain'), 8, __FILE__, array('DavesWordPressLiveSearch', 'plugin_options'));
		}
	}
	
	/**
	 * Display & process the Live Search admin options
	 * @return void
	 */
	public function plugin_options()
	{
		$thisPluginsDirectory = dirname(__FILE__);
		
		if("Save Changes" == $_POST['daves-wordpress-live-search_submit'] && current_user_can('manage_options'))
		{
			check_admin_referer('daves-wordpress-live-search-config');
			
			// Read their posted value
	        $maxResults = max(intval($_POST['daves-wordpress-live-search_max_results']), 0);
	        $resultsDirection = $_POST['daves-wordpress-live-search_results_direction'];
	        $displayPostMeta = ("true" == $_POST['daves-wordpress-live-search_display_post_meta']);
	        $cssOption = $_POST['daves-wordpress-live-search_css'];
	        $showThumbs = $_POST['daves-wordpress-live-search_thumbs'];
	        $showExcerpt = $_POST['daves-wordpress-live-search_excerpt'];
	        $exceptions = $_POST['daves-wordpress-live-search_exceptions'];

	        // Save the posted value in the database
	        update_option('daves-wordpress-live-search_max_results', $maxResults );	
	        update_option('daves-wordpress-live-search_results_direction', $resultsDirection);
	        update_option('daves-wordpress-live-search_display_post_meta', (string)$displayPostMeta);
	        update_option('daves-wordpress-live-search_css_option', $cssOption );
	        update_option('daves-wordpress-live-search_thumbs', $showThumbs);	
	        update_option('daves-wordpress-live-search_excerpt', $showExcerpt);
	        update_option('daves-wordpress-live-search_exceptions', $exceptions);
	        
	        // Translate the "Options saved" message...just in case.
	        // You know...the code I was copying for this does it, thought it might be a good idea to leave it
	        $updateMessage = __('Options saved.', 'mt_trans_domain' );
	        
	        echo "<div class=\"updated fade\"><p><strong>$updateMessage</strong></p></div>";
		}
		else
		{
			$maxResults = intval(get_option('daves-wordpress-live-search_max_results'));
			$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));
			$displayPostMeta = (bool)get_option('daves-wordpress-live-search_display_post_meta');
			$cssOption = get_option('daves-wordpress-live-search_css_option');
			$showThumbs = (bool) get_option('daves-wordpress-live-search_thumbs');
			$showExcerpt = (bool) get_option('daves-wordpress-live-search_excerpt');
			$exceptions = get_option('daves-wordpress-live-search_exceptions');
		}
	        
	    if(!in_array($resultsDirection, array('up', 'down')))
	        	$resultsDirection = 'down';

	    switch($cssOption)
	    {
	    	case 'theme':
	    		$css = 'theme';
	    		break;
	    	case 'default_red':
	    		$css = 'default_red';
	    		break;
	    	case 'default_blue':
	    		$css = 'default_blue';
	    		break;
	    	case 'default_gray':
	    	default:
	    		$css = 'default_gray';
	    }

		include("$thisPluginsDirectory/daves-wordpress-live-search-admin.tpl");
	}
	
	public function admin_notices()
	{
		$cssOption = get_option('daves-wordpress-live-search_css_option');
		if('theme' == $cssOption)
		{
			// Make sure there's a daves-wordpress-live-search.css file in the theme
			if(!file_exists(TEMPLATEPATH."/daves-wordpress-live-search.css"))
			{
				$alertMessage = __("The <em>Dave's WordPress Live Search</em> plugin is configured to use a theme-specific CSS file, but the current theme does not contain a daves-wordpress-live-search.css file.");
				echo "<div class=\"updated fade\"><p><strong>$alertMessage</strong></p></div>";
	
			}
		}
	}
	
	private function isSearchablePage() {
		if(is_admin()) return false;

		$searchable = true;
		$exceptions = explode("\n", get_option('daves-wordpress-live-search_exceptions'));

		foreach($exceptions as $exception) {
			$regexp = trim($exception);
			if('<front>' == $regexp) {
				$regexp = '';	
			}
			
			// These checks can probably be turned into regexps themselves,
			// but it's too early in the morning to be writing regexps
			if('*' == substr($regexp, 0, 1)) {
				$regexp = substr($regexp, 1);
			}
			else {
				$regexp = '^'.$regexp;
			}

			if('*' == substr($regexp, -1)) {
				$regexp = substr($regexp, 0, -1);
			}
			else {
				$regexp = $regexp.'$';
			}
			
			$regexp = '|'.$regexp.'|';
			if(preg_match($regexp, substr($_SERVER['REQUEST_URI'], 1)) > 0) {
				return false;
			}	
		}

		// Fall-through, search everything by default
		return true;
	}
}
?>