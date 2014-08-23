<?php

//die( 'filter_examples.php contains examples only' );

/*********
 * dwls_alter_results example
 *
 * We have a Custom Post Type called "liveblog" for our coverage of Apple keynotes.
 * Flag those search results with [LiveBlog] so people know those are LiveBlog posts and not actual articles.

 * @param array $wpQueryResults Array of WP_Post objects
 * @param $deprecated
 * @param DavesWordPressLiveSearchResults $davesWordPressLiveSearchResults
 *
 * @return mixed
 */
function add_liveblog_flag( $wpQueryResults, $deprecated, $davesWordPressLiveSearchResults ) {

	// Loop through all the search results
	foreach ( $wpQueryResults as $result ) {
		if ( $result->post_type === 'liveblog' ) {
			$result->post_title = '[LiveBlog] ' . $result->post_title;
		}
	}

	return $wpQueryResults;

}

add_filter( 'dwls_alter_results', 'add_liveblog_flag', 10, 3 );