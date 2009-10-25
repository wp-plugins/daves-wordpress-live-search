<div class="wrap">
<h2>Dave's WordPress Live Search Options</h2>

<form method="post" action="">

<?php
if ( function_exists('wp_nonce_field') )
	wp_nonce_field('daves-wordpress-live-search-config');
?>

<table class="form-table"><tbody>

<!-- Maximum results -->
<tr valign="top">
<th scope="row">Maximum Results to Display</th>

<td><input type="text" name="daves-wordpress-live-search_max_results" id="daves-wordpress-live-search_max_results" value="<?php echo $maxResults; ?>" class="regular-text code" /><span class="setting-description">Enter "0" to display all matching results</span></td>
</tr>

<tr valign="top">
<th scope="row">Results Direction</th>

<td><input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_down" value="down" <?php if($resultsDirection == 'down'): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_results_direction_down">Down</input></label>

<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_up" value="up" <?php if($resultsDirection == 'up'): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_results_direction_up">Up</label><br /><span class="setting-description">When search results are displayed, in which direction should the results box extend from the search box?</span></td>
</tr>

<!-- Display post meta -->
<tr valign="top">
<th scope="row">Display Metadata</th>

<td><input type="checkbox" name="daves-wordpress-live-search_display_post_meta" id="daves-wordpress-live-search_display_post_meta" value="true" <?php if($displayPostMeta): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_display_post_meta">Display author & date for every search result</label></td> 
</tr>

<!-- Display post thumbnail -->
<tr valign="top">
<th scope="row">Display Post Thumbnail</th>

<td><input type="checkbox" name="daves-wordpress-live-search_thumbs" id="daves-wordpress-live-search_thumbs" value="true" <?php if($showThumbs): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_thumbs">Display thumbnail images for every search result with at least one image</label></td> 
</tr>

<!-- Display post excerpt -->
<tr valign="top">
<th scope="row">Display Post Excerpt</th>

<td><input type="checkbox" name="daves-wordpress-live-search_excerpt" id="daves-wordpress-live-search_excerpt" value="true" <?php if($showExcerpt): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_excerpt">Display an excerpt for every search result. If the post doesn't have one, the first 100 characters are used.</label></td> 
</tr>

<!-- CSS styles -->
<tr valign="top">
<td colspan="2"><h3>Styles</h3></td>
</tr>

<tr valign="top">
<th scope="row"> </th>
<td>

<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_gray" value="default_gray" <?php if('default_gray' == $css): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_css_default_gray">Default Gray</label><br /><span class="setting-description">Default style in gray.</span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_red" value="default_red" <?php if('default_red' == $css): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_css_default_red">Default Red</label><br /><span class="setting-description">Default style in red</span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_blue" value="default_blue" <?php if('default_blue' == $css): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_css_default_blue">Default Blue</label><br /><span class="setting-description">Default style in blue</span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_theme" value="theme" <?php if('theme' == $css): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_css_theme">Theme-specific</label><br /><span class="setting-description"><strong>For advanced users:</strong> Theme must include a CSS file named daves-wordpress-live-search.css. If your theme does not have one, copy daves-wordpress-live-search_default_gray.css from this plugin's directory into your theme's directory and modify as desired.</span>
</td> 
</tr>

<!-- Submit buttons -->
<tr valign="top">
<td colspan="2"><div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;"><input type="submit" name="daves-wordpress-live-search_submit" id="daves-wordpress-live-search_submit" value="Save Changes" /></div></td>
</tr>

</tbody></table>

</form>

<!-- Note -->

<p>
Please Note: For faster page loading times, consider installing the <a href="http://wordpress.org/extend/plugins/use-google-libraries">Use Google Libraries</a> plugin.
</p>

<p>Want better search results? Dave recommends installing <a href="http://wordpress.org/extend/plugins/search-unleashed/">Search Unleashed</a> or <a href="http://wordpress.org/extend/plugins/search-everything/">Search Everything</a> to make WordPress search comments and metadata, too!</p>
</div>