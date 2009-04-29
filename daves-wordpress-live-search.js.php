<!-- Dave's WordPress Live Search JS -->
<script type="text/javascript"> 
<?php

$resultsDirection = stripslashes(get_option('daves-wordpress-live-search_results_direction'));

?>

///////////////////////
// LiveSearch
///////////////////////

function LiveSearch() {}

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
	jQuery("input[name='s']").keyup(LiveSearch.handleKeypress);
	
	// Prevent browsers from doing autocomplete on the search field
	jQuery("input[name='s']").attr('autocomplete', 'off');
	
	// Hide the search results when the search box loses focus
	jQuery("*").click(LiveSearch.handleClicks);
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
	jQuery("body").children("ul.search_results").css('display', 'none');
	jQuery("body").children("ul.search_results").css('top', topOffset + 'px');
};

LiveSearch.handleClicks = function(e) {
	
	var target = jQuery(this);
	
	if(this.tagName == "INPUT" && target.attr('name') == "s") {
		e.stopPropagation();
	}
	
	if(this.tagName == "UL" && target.hasClass('search_results')) {
		e.stopPropagation();
	}
			
	if(this.tagName == "HTML") {
		// If this is executing, the event has propagated all the way
		// to the <html> tag itself without being stopped,
		// so it must not have been the search box or the results that
		// were clicked.
		LiveSearch.hideResults();	
	}
};

/**
 * Process the search results that came back from the AJAX call
 */
LiveSearch.handleAJAXResults = function(e) {
	
	resultsSearchTerm = e.query_vars.s;
	if(resultsSearchTerm != jQuery("input[name='s']").val()) {
		return;
	}
	
	var resultsShownFor = jQuery("ul.search_results").children("input[name=query]").val();
	if(resultsShownFor != "" && resultsSearchTerm == resultsShownFor)
		return;

	var searchResultsList = jQuery("ul.search_results");
	searchResultsList.empty();
	searchResultsList.append('<input type="hidden" name="query" value="' + resultsSearchTerm + '" />');

	if(e.post_count === 0) {
		// Hide the search results, no results to show
		LiveSearch.hideResults();
	}
	else {
		for(var postIndex = 0; postIndex < e.posts.length; postIndex++) {
			var searchResult = e.posts[postIndex];
			if(searchResult.post_title !== undefined) {
				searchResultsList.append('<li><a href="' + searchResult.guid + '">' + searchResult.post_title + '</a><p id="daves-wordpress-live-search_author">Posted by ' + searchResult.post_author_nicename + '</p><p id="daves-wordpress-live-search_date">' + searchResult.post_date + '</p></li>');
				
			}

		}
		
		// Show the search results
		LiveSearch.showResults();

	}
	
	LiveSearch.removeIndicator();
};

/**
 * Keypress handler. Sets up a 0 sec. timeout which then
 * kicks off the actual query.s
 */
LiveSearch.handleKeypress = function(e) {
	var delayTime = 0;
	var term = jQuery("input[name='s']").val();
	var func = "LiveSearch.runQuery(" + e.which + ", '" + term + "')";
	setTimeout(func, delayTime);
};

/**
 * Do the AJAX request for search results, or hide the search results
 * if the search box is empty.
 */
LiveSearch.runQuery = function(keyPressed, terms) {
	
	if(jQuery("input[name='s']").val() === "") {
		// Nothing entered. Hide the autocomplete.
		LiveSearch.hideResults();
		LiveSearch.removeIndicator();
	}
	else {
		// Do an autocomplete lookup
		LiveSearch.displayIndicator();
		
		// do AJAX query
		//var currentSearch = jQuery("input[name='s']").val();
		var currentSearch = terms;
		
		jQuery.getJSON( "<?php print $pluginPath; ?>daves-wordpress-live-search-ajax.php", {s: currentSearch}, LiveSearch.handleAJAXResults); 	
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
</script>
<!-- END:Dave's WordPress Live Search JS -->
