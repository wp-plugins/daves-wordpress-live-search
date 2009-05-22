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

if (!function_exists('json_encode'))
{
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

include_once("../../../wp-config.php");

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
		$this->populate($wpQueryResults);
		$this->displayPostMeta = $displayPostMeta;
	}
	
	private function populate($wpQueryResults) {
		$this->searchTerms = $wpQueryResults->query_vars['s'];
		foreach($wpQueryResults->posts as $result)
		{
			$this->results[] = $result;	
		}
	}
}

$wp_query = new WP_Query(array('s' => $_GET['s'], 'showposts' => 100));

// Add author names

$authorCache = array();
foreach($wp_query->posts as $index=>$post)
{
	$authorID = $post->post_author;
	if(array_key_exists($authorID, $authorCache))
	{
		$authorName = $authorCache[$authorID];
	}
	else
	{
		$authorData = get_userdata($authorID);
		$authorName = $authorData->user_nicename;
		$authorCache[$authorID] = $authorData->user_nicename;
	}
	
	$post->post_author_nicename = $authorName;
	
	unset($post->post_content);
}

$maxResults = intval(get_option('daves-wordpress-live-search_max_results'));
if($maxResults > 0)
{
	$wp_query->posts = array_slice($wp_query->posts, 0, $maxResults);
}

$results = new DavesWordPressLiveSearchResults($wp_query, (bool)get_option('daves-wordpress-live-search_display_post_meta'));

$json = json_encode($results);

print $json;

?>