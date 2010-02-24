<?php
ob_start();
header('Content-type: text/javascript');

// Borrowed from wp-load.php
// PHP 5.3 with E_STRICT throws a bunch of warnings when we get to
// wp-settings.php (included by wp-config.php)
if ( defined('E_RECOVERABLE_ERROR') )
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);
	
include "daves-wordpress-live-search-bootstrap.php";

$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));

$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));
$showThumbs = ("true" == get_option('daves-wordpress-live-search_thumbs'));
$showExcerpt = ("true" == get_option('daves-wordpress-live-search_excerpt'));
$minCharsToSearch = intval(get_option('daves-wordpress-live-search_minchars'));
?>

///////////////////////
// LiveSearch
///////////////////////

function LiveSearch() {
	var resultsElement = '';
	var searchBoxes = '';
}

LiveSearch.activeRequests = new Array();

/**
 * Initialization for the live search plugin.
 * Sets up the key handler and creates the search results list.
 */
LiveSearch.init = function() {
	
	jQuery("body").append('<ul class="search_results"></ul>');
	this.resultsElement = jQuery('ul.search_results');
	this.resultsElement.hide();
	
	// Add the keypress handler
	// Using keyup because keypress doesn't recognize the backspace key
	// and that's kind of important.
	LiveSearch.searchBoxes = jQuery("input[name='s']");
	LiveSearch.searchBoxes.keyup(LiveSearch.handleKeypress);
	
	// Prevent browsers from doing autocomplete on the search field
	LiveSearch.searchBoxes.parent('form').attr('autocomplete', 'off');
	
	// Hide the search results when the search box loses focus
	jQuery("html").click(LiveSearch.hideResults);
	LiveSearch.searchBoxes.add(this.resultsElement).click(function(e) { e.stopPropagation(); });
	
}

LiveSearch.positionResults = function() {
	
	// Look for the search box. Exit if there isn't one.
	if(LiveSearch.searchBoxes.size() === 0) {
		return false;
	}
		
	// Position the ul right under the search box	
	var searchBoxPosition = LiveSearch.searchBoxes.offset();
	this.resultsElement.css('left', searchBoxPosition.left);

	this.resultsElement.css('display', 'block');
	var topOffset = <?php
		switch($resultsDirection)
		{
			case 'up':
				echo 'searchBoxPosition.top - this.resultsElement.height();';
				break;
			case 'down':
			default:
				echo "searchBoxPosition.top + LiveSearch.searchBoxes.outerHeight();";
		}
	?>

	this.resultsElement.css('top', topOffset + 'px');
};

/**
 * Process the search results that came back from the AJAX call
 */
LiveSearch.handleAJAXResults = function(e) {
	
	var showThumbs = <?php if($showThumbs) : ?>true<?php else : ?>false<?php endif; ?>;
	var showExcerpt = <?php if($showExcerpt) : ?>true<?php else : ?>false<?php endif; ?>;
	
	LiveSearch.activeRequests.pop();

	resultsSearchTerm = e.searchTerms;
	if(resultsSearchTerm != LiveSearch.searchBoxes.val()) {
		
		if(LiveSearch.activeRequests.length == 0) {
			LiveSearch.removeIndicator();
		}

		return;
	}
	
	var resultsShownFor = jQuery("ul.search_results").children("input[name=query]").val();
	if(resultsShownFor != "" && resultsSearchTerm == resultsShownFor)
	{
		if(LiveSearch.activeRequests.length == 0) {
			LiveSearch.removeIndicator();
		}

		return;
	}

	var searchResultsList = jQuery("ul.search_results");
	searchResultsList.empty();
	searchResultsList.append('<input type="hidden" name="query" value="' + resultsSearchTerm + '" />');

	if(e.results.length == 0) {
		// Hide the search results, no results to show
		LiveSearch.hideResults();
	}
	else {
		for(var postIndex = 0; postIndex < e.results.length; postIndex++) {
			var searchResult = e.results[postIndex];
			if(searchResult.post_title !== undefined) {
				


				var renderedResult = '';
				
				// Thumbnails
				if(showThumbs && searchResult.attachment_thumbnail) {
					var liClass = "post_with_thumb";
				}
				else {
					var liClass = "";
				}
				
				renderedResult += '<li class="' + liClass + '">';
				
				// Render thumbnail
				if(showThumbs && searchResult.attachment_thumbnail) {
					renderedResult += '<img src="' + searchResult.attachment_thumbnail + '" class="post_thumb" />';
				}
				
				renderedResult += '<a href="' + searchResult.permalink + '">' + searchResult.post_title + '</a>';

				if(showExcerpt && searchResult.post_excerpt) {
					renderedResult += '<p class="excerpt clearfix">' + searchResult.post_excerpt + '</p>';
				}
				
				if(e.displayPostMeta) {
					renderedResult += '<p class="meta clearfix" id="daves-wordpress-live-search_author">Posted by ' + searchResult.post_author_nicename + '</p><p id="daves-wordpress-live-search_date" class="meta clearfix">' + searchResult.post_date + '</p>';
					renderedResult += '<div class="clearfix"></div></li>';

				}
				searchResultsList.append(renderedResult);
			}
		}
		
		// "more" link
		searchResultsList.append('<div class="clearfix search_footer"><a href="<?php bloginfo('url'); ?>/?s=' + resultsSearchTerm + '">View more results</a></div>');

		// Show the search results
		LiveSearch.showResults();

	}
	
	if(LiveSearch.activeRequests.length == 0) {
		LiveSearch.removeIndicator();
	}
};

/**
 * Keypress handler. Sets up a 0 sec. timeout which then
 * kicks off the actual query.s
 */
LiveSearch.handleKeypress = function(e) {
	var delayTime = 0;
	var term = LiveSearch.searchBoxes.val();
	setTimeout( function() { LiveSearch.runQuery(term); }, delayTime);
};

/**
 * Do the AJAX request for search results, or hide the search results
 * if the search box is empty.
 */
LiveSearch.runQuery = function(terms) {
	
	var srch=LiveSearch.searchBoxes.val();
	if(srch === "" || srch.length < <?php echo $minCharsToSearch; ?>) {
		// Nothing entered. Hide the autocomplete.
		LiveSearch.hideResults();
		LiveSearch.removeIndicator();
	}
	else {
		// Do an autocomplete lookup
		LiveSearch.displayIndicator();
		
		// Clear out the old requests in the queue
		while(LiveSearch.activeRequests.length > 0)
		{
			var req = LiveSearch.activeRequests.pop();
			req.abort();
		}
		// do AJAX query
		//var currentSearch = jQuery("input[name='s']").val();
		var currentSearch = terms;
		
		var req = jQuery.getJSON( "<?php print $pluginPath; ?>daves-wordpress-live-search-ajax.php", {s: currentSearch}, LiveSearch.handleAJAXResults);
		
		// Add this request to the queue
		LiveSearch.activeRequests.push(req);
	}
};

LiveSearch.hideResults = function() {
	switch('<?php echo $resultsDirection; ?>')
	{
		case 'up':
			jQuery("ul.search_results:visible").fadeOut();
			return;
		case 'down':
		default:
			jQuery("ul.search_results:visible").slideUp();
			return;
	}
};

LiveSearch.showResults = function() {

	this.positionResults();
	
	switch('<?php echo $resultsDirection; ?>')
	{
		case 'up':
			jQuery("ul.search_results:hidden").fadeIn();
			return;
		case 'down':
		default:
			jQuery("ul.search_results:hidden").slideDown();	
			return;
	}
};

/**
 * Display the "spinning wheel" AJAX activity indicator
 */
LiveSearch.displayIndicator = function() {
	
	if(jQuery("#search_results_activity_indicator").size() === 0) {

		jQuery("body").append('<img id="search_results_activity_indicator" src="<?php print $pluginPath; ?>indicator.gif" />');

		var searchBoxPosition = LiveSearch.searchBoxes.offset();

		jQuery("#search_results_activity_indicator").css('position', 'absolute');
		
		var indicatorY = (searchBoxPosition.top + ((LiveSearch.searchBoxes.outerHeight() - LiveSearch.searchBoxes.innerHeight()) / 2) + 'px');
		
		jQuery("#search_results_activity_indicator").css('top', indicatorY);

		var indicatorX = (searchBoxPosition.left + LiveSearch.searchBoxes.outerWidth() - <?php $dimensions = getimagesize("$pluginPath/indicator.gif"); print $dimensions[0]; ?> - 2) + 'px';
						
		jQuery("#search_results_activity_indicator").css('left', indicatorX);
	}
};

/**
 * Hide the "spinning wheel" AJAX activity indicator
 */
LiveSearch.removeIndicator = function() {
	jQuery("#search_results_activity_indicator").remove();
};

///////////////////
// Initialization
///////////////////

jQuery(function() {
	LiveSearch.init();
});
