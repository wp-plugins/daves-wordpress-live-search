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

// Provide a json_encode implementation if none exists (PHP < 5.2.0)
if (!function_exists('json_encode'))
{
	/**
	 * json_encode implementation for PHP 4.x by "Steve". Serializes data into JSON.
	 * @see http://www.php.net/manual/en/function.json-encode.php#82904
	 * @param mixed $a data to serialize
	 * @return mixed serialized data|scalar
	 */
	function json_encode($a=false)
	{
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar($a))
		{
			if (is_float($a))
			{
			  // Always use "." for floats.
			  return floatval(str_replace(",", ".", strval($a)));
			}
		
			if (is_string($a))
			{
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			}
			else
				return $a;
		}
		
		$isList = true;
		for ($i = 0, reset($a); $i < count($a); $i++, next($a))
		{
			if (key($a) !== $i)
			{
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList)
		{
			foreach ($a as $v) $result[] = json_encode($v);
			return '[' . join(',', $result) . ']';
		}
		else
		{
			foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}
}

include "daves-wordpress-live-search-bootstrap.php";

/**
 * Value object class
 */
class DavesWordPressLiveSearchResults {
	public $searchTerms;
	public $results;
	public $displayPostMeta;
	
	/**
	 * @param WP_Query $wpQueryResults
	 * @param boolean $displayPostMeta Show author & date for each post. Defaults to TRUE to keep original bahavior from before I added this flag
	 */
	function DavesWordPressLiveSearchResults(WP_Query $wpQueryResults, $displayPostMeta = true) {
		$this->results = array();
		$this->populate($wpQueryResults, $displayPostMeta);
		$this->displayPostMeta = $displayPostMeta;
	}
	
	private function populate($wpQueryResults, $displayPostMeta) {
		
		global $wp_locale;
		$dateFormat = get_option('date_format');
		
		$this->searchTerms = $wpQueryResults->query_vars['s'];
		
		foreach($wpQueryResults->posts as $result)
		{
			// Add author names & permalinks
			if($displayPostMeta)
				$result->post_author_nicename = $this->authorName($result->post_author);
				
			$result->permalink = get_permalink($result->ID);
			
			if(function_exists('get_post_image_id')) {
				// Support for WP 2.9 post thumbnails
				$postImageID = get_post_image_id($result->ID);
				$postImageData = wp_get_attachment_image_src($postImageID, apply_filters('post_image_size', 'thumbnail'));
				 $result->attachment_thumbnail = $postImageData[0];
			}
			else {
				// If not post thumbnail, grab the first image from the post
				$result->attachment_thumbnail = $this->firstImageThumb($result->ID);
			}

			$result->post_excerpt = $this->excerpt($result);
			
			$result->post_date = date_i18n($dateFormat, strtotime($result->post_date));
			
			// We don't want to send all this content to the browser
			unset($result->post_content);
			
			$this->results[] = $result;	
		}
	}
	
	private function excerpt($result) {
		if (empty($result->post_excerpt)) {
			 $excerpt = explode(" ",strrev(substr(strip_tags($result->post_content), 0, 100)),2);
			 $excerpt = strrev($excerpt[1]);
			 $excerpt .= " [...]";
		}
		else {
			$excerpt = $result->post_excerpt;
		}
		
		return $excerpt;
	}
	
	/**
	 * @return string
	 */
	private function authorName($authorID) {
		static $authorCache = array();
		
		if(array_key_exists($authorID, $authorCache))
		{
			$authorName = $authorCache[$authorID];
		}
		else
		{
			$authorData = get_userdata($authorID);
			$authorName = $authorData->display_name;
			$authorCache[$authorID] = $authorName;
		}
		
		return $authorName;
	}

	/**
	 * @see http://wphackr.com/get-images-attached-to-post/
	 */	
	function firstImageThumb($postID) {
	
		// Get images for this post
		$arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $postID );
		
		// If images exist for this page
		if($arrImages) {
		
			// Get array keys representing attached image numbers
			$arrKeys = array_keys($arrImages);
			
			/******BEGIN BUBBLE SORT BY MENU ORDER************/
			// Put all image objects into new array with standard numeric keys (new array only needed while we sort the keys)
			foreach($arrImages as $oImage) {
			$arrNewImages[] = $oImage;
			}
			
			// Bubble sort image object array by menu_order TODO: Turn this into std "sort-by" function in functions.php
			for($i = 0; $i < sizeof($arrNewImages) - 1; $i++) {
				for($j = 0; $j < sizeof($arrNewImages) - 1; $j++) {
					if((int)$arrNewImages[$j]->menu_order > (int)$arrNewImages[$j + 1]->menu_order) {
						$oTemp = $arrNewImages[$j];
						$arrNewImages[$j] = $arrNewImages[$j + 1];
						$arrNewImages[$j + 1] = $oTemp;
					}
				}
			}
			 
			// Reset arrKeys array
			$arrKeys = array();
			 
			// Replace arrKeys with newly sorted object ids
			foreach($arrNewImages as $oNewImage) {
				$arrKeys[] = $oNewImage->ID;
			}
			
			/******END BUBBLE SORT BY MENU ORDER**************/
			
			// Get the first image attachment
			$iNum = $arrKeys[0];
			
			// Get the thumbnail url for the attachment
			$sThumbUrl = wp_get_attachment_thumb_url($iNum);
			
			return $sThumbUrl;
		}
	}
}

$maxResults = intval(get_option('daves-wordpress-live-search_max_results'));
if($maxResults === 0) $maxResults = -1;

// Initialize the $wp global object
// See class WP in classes.php
// The Relevanssi plugin is using this instead of
// the global $wp_query object
$wp =& new WP();
$wp->init();  // Sets up current user.
$wp->parse_request();

// This used to be one line, with the search parameters passed to the
// WP_Query constructor. But, the Search Everything plugin reliest on having
// $wp_query available in the global scope when WP_Query calls it. So, I had
// to split this line up and call WP_Query::query manually in order to be
// compatible with plugins that hook into the search engine.
$wp_query = new WP_Query();
$wp_query->query(array('s' => $_GET['s'], 'showposts' => $maxResults));

$displayPostMeta = (bool)get_option('daves-wordpress-live-search_display_post_meta');
$results = new DavesWordPressLiveSearchResults($wp_query, $displayPostMeta);

$json = json_encode($results);

print $json;

?>