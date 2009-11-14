<?php
ob_start();
header('Content-type: text/javascript');

include("../../../wp-config.php");

$pluginPath = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));

$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));
$showThumbs = ("true" == get_option('daves-wordpress-live-search_thumbs'));
$showExcerpt = ("true" == get_option('daves-wordpress-live-search_excerpt'));
?>

///////////////////////
// LiveSearch
///////////////////////

function LiveSearch() {}

LiveSearch.activeRequests = new Array();

/**
 * Initialization for the live search plugin.
 * Sets up the key handler and creates the search results list.
 */
LiveSearch.init = function() {
	
	jQuery("body").append('<ul class="search_results"></ul>');
	jQuery("body").children("ul.search_results").hide();
	
	// Add the keypress handler
	// Using keyup because keypress doesn't recognize the backspace key
	// and that's kind of important.
	var searchBoxes = jQuery("input[name='s']");
	searchBoxes.keyup(LiveSearch.handleKeypress);
	
	// Prevent browsers from doing autocomplete on the search field
	searchBoxes.attr('autocomplete', 'off');
	
	// Hide the search results when the search box loses focus
	jQuery("html").click(LiveSearch.hideResults);
	searchBoxes.add("ul.search_results").click(LiveSearch.handleClicks);
}

LiveSearch.positionResults = function() {
	
	// Look for the search box. Exit if there isn't one.
	var searchBox = jQuery("input[name='s']");
	if(searchBox.size() === 0) {
		return false;
	}
		
	// Position the ul right under the search box	
	var searchBoxPosition = searchBox.offset();
	jQuery("body").children("ul.search_results").css('left', searchBoxPosition.left);

	jQuery("body").children("ul.search_results").css('display', 'block');
	var topOffset = <?php
		switch($resultsDirection)
		{
			case 'up':
				echo 'searchBoxPosition.top - jQuery("ul.search_results").height();';
				break;
			case 'down':
			default:
				echo "searchBoxPosition.top + searchBox.outerHeight();";
		}
	?>

	jQuery("body").children("ul.search_results").css('top', topOffset + 'px');
};

LiveSearch.handleClicks = function(e) {
	e.stopPropagation();
};

/**
 * Process the search results that came back from the AJAX call
 */
LiveSearch.handleAJAXResults = function(e) {
	
	var showThumbs = <?php if($showThumbs) : ?>true<?php else : ?>false<?php endif; ?>;
	var showExcerpt = <?php if($showExcerpt) : ?>true<?php else : ?>false<?php endif; ?>;
	
	LiveSearch.activeRequests.pop();

	resultsSearchTerm = e.searchTerms;
	if(resultsSearchTerm != jQuery("input[name='s']").val()) {
		
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
		searchResultsList.append('<div class="clearfix search_footer"><a href="?s=' + resultsSearchTerm + '">View more results</a></div>');

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
	var term = jQuery("input[name='s']").val();
	setTimeout( function() { LiveSearch.runQuery(term); }, delayTime);
};

/**
 * Do the AJAX request for search results, or hide the search results
 * if the search box is empty.
 */
LiveSearch.runQuery = function(terms) {
	
	if(jQuery("input[name='s']").val() === "") {
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
		
		var searchBox = jQuery("input[name='s']");

		var searchBoxPosition = searchBox.offset();

		jQuery("#search_results_activity_indicator").css('position', 'absolute');
		
		var indicatorY = (searchBoxPosition.top + ((searchBox.outerHeight() - searchBox.innerHeight()) / 2) + 'px');
		
		jQuery("#search_results_activity_indicator").css('top', indicatorY);

		var indicatorX = (searchBoxPosition.left + searchBox.outerWidth() - <?php $dimensions = getimagesize("$pluginPath/indicator.gif"); print $dimensions[0]; ?> - 2) + 'px';
						
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

jQuery(document).ready( function() {
	LiveSearch.init();
});
