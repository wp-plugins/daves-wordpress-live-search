<style type="text/css">
/* Used on the built-in themes page to provide the line under the tabs */
.settings_page_daves-wordpress-live-search-DavesWordPressLiveSearch .wrap h2 {
border-bottom: 1px solid #ccc;
padding-bottom: 0px;
}
</style>

<div class="wrap">
<h2>Dave's WordPress Live Search Options</h2>
<h2>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=settings"; ?>" class="nav-tab nav-tab-active">Settings</a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=advanced"; ?>" class="nav-tab">Advanced</a>
<?php if($enableDebugger) : ?><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=debug"; ?>" class="nav-tab">Debug</a><?php endif; ?>
</h2>
<form method="post" action="">
<input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>" />

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
<th scope="row">Minimum characters before searching</th>

<td>
<select name="daves-wordpress-live-search_minchars">
<option value="1" <?php if($minCharsToSearch == 1) echo 'selected="selected"'; ?>>Search right away</option>
<option value="2" <?php if($minCharsToSearch == 2) echo 'selected="selected"'; ?>>Wait for two characters</option>
<option value="3" <?php if($minCharsToSearch == 3) echo 'selected="selected"'; ?>>Wait for three characters</option>
<option value="4" <?php if($minCharsToSearch == 4) echo 'selected="selected"'; ?>>Wait for four characters</option>
</select>
</td>
</tr>


<tr valign="top">
<th scope="row">Results Direction</th>

<td><input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_down" value="down" <?php if($resultsDirection == 'down'): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_results_direction_down">Down</input></label>

<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_up" value="up" <?php if($resultsDirection == 'up'): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_results_direction_up">Up</label><br /><span class="setting-description">When search results are displayed, in which direction should the results box extend from the search box?</span></td>
</tr>

<!-- Display post meta -->
<tr valign="top">
<th scope="row">Display Metadata</th>

<td>
    <input type="hidden" name="daves-wordpress-live-search_display_post_meta" value="" />
    <input type="checkbox" name="daves-wordpress-live-search_display_post_meta" id="daves-wordpress-live-search_display_post_meta" value="true" <?php if($displayPostMeta): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_display_post_meta">Display author & date for every search result</label>
</td> 
</tr>

<!-- Display post thumbnail -->
<tr valign="top">
<th scope="row">Display Post Thumbnail</th>

<td>
    <input type="hidden" name="daves-wordpress-live-search_thumbs" value="" />
    <input type="checkbox" name="daves-wordpress-live-search_thumbs" id="daves-wordpress-live-search_thumbs" value="true" <?php if($showThumbs): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_thumbs">Display thumbnail images for every search result with at least one image</label>
</td> 
</tr>

<!-- Display post excerpt -->
<tr valign="top">
<th scope="row">Display Post Excerpt</th>

<td>
    <input type="hidden" name="daves-wordpress-live-search_excerpt" value="" />
    <input type="checkbox" name="daves-wordpress-live-search_excerpt" id="daves-wordpress-live-search_excerpt" value="true" <?php if($showExcerpt): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_excerpt">Display an excerpt for every search result. If the post doesn't have one, the first 100 characters are used.</label>
</td> 
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
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_existing_theme" value="notheme" <?php if('notheme' == $css): ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_css_theme">Theme-specific (theme's own CSS file)</label><br /><span class="setting-description"><strong>For advanced users:</strong> Use the styles contained within your Theme's stylesheet. Don't include a separate stylesheet for Live Search.
</td> 
</tr>

<!-- WP E-Commerce -->
<?php if(defined('WPSC_VERSION')) : ?>
<tr valign="top">
<td colspan="2"><h3>WP E-Commerce</h3></td>
</tr>

<tr valign="top">
<th scope="row"> </th>
<td>
    <div><span class="setting-description">When used with the <a href="http://getshopped.org/">WP E-Commerce</a> plugin, Dave's WordPress Live Search can search your product catalog instead of posts & pages.</span></div>
    <table>
        <tr><td><input type="radio" id="daves-wordpress-live-search_source_1" name="daves-wordpress-live-search_source" value="0" <?php if(0 == $searchSource) : ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_source_1">Search posts &amp; pages</label></td></tr>
        <tr><td><input type="radio" id="daves-wordpress-live-search_source_2" name="daves-wordpress-live-search_source" value="1" <?php if(1 == $searchSource) : ?>checked="checked"<?php endif; ?> /><label for="daves-wordpress-live-search_source_2">Search products</label></td></tr>
    </table>

</td>
</tr>
<?php else : ?>
<input type="hidden" name="daves-wordpress-live-search_source" value="0" />
<?php endif; ?>

<!-- Submit buttons -->
<tr valign="top">
<td colspan="2"><div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;"><input type="submit" name="daves-wordpress-live-search_submit" id="daves-wordpress-live-search_submit" value="Save Changes" /></div></td>
</tr>

</tbody></table>

</form>

<!-- Note -->

<p>Do you find this plugin useful? Consider a donation to <a href="http://catguardians.org">Cat Guardians</a>, a wonderful no-kill shelter where I volunteer.</p>
</div>