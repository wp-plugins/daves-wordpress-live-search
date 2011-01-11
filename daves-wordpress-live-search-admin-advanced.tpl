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
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=settings"; ?>" class="nav-tab">Settings</a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=advanced"; ?>" class="nav-tab nav-tab-active">Advanced</a>
</h2>
<form method="post" action="">
<input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>" />

<?php
if ( function_exists('wp_nonce_field') )
	wp_nonce_field('daves-wordpress-live-search-config');
?>

<table class="form-table"><tbody>

<tr valign="top">
<th scope="row">Exceptions</th>

<td>
<?php $permalinkFormat = get_option('permalink_structure'); ?>
<div><span class="setting-description">Enter the <?php echo empty($permalinkFormat) ? 'paths' : 'permalinks'; ?> of pages which should not have live searching, one per line. The * wildcard can be used at the start or end of a line. For example: <ul style="list-style-type:disc;margin-left: 3em;"><?php echo empty($permalinkFormat) ? '<li>?page_id=123</li><li>page_id=1*</li>' : '<li>about</li><li>employee-*</li>';?></ul></span></div>
<textarea name="daves-wordpress-live-search_exceptions" id="daves-wordpress-live-search_exceptions" rows="5" cols="60"><?php echo $exceptions; ?></textarea></td> 
</tr>

<!-- X Offset -->
<tr valign="top">
<th scope="row">Search Results box X offset</th>

<td>
<div><span class="setting-description">Use this setting to move the search results box left or right to align exactly with your theme's search field. Value is in pixels. Negative values move the box to the left, positive values move it to the right.</span></div>

<input type="text" name="daves-wordpress-live-search_xoffset" id="daves-wordpress-live-search_xoffset" value="<?php echo $xOffset; ?>"</td> 
</tr>

<!-- Cache lifetime -->
<tr valign="top">
<th scope="row">Cache Lifetime</th>

<td><input type="text" name="daves-wordpress-live-search_cache_lifetime" id="daves-wordpress-live-search_cache_lifetime" value="<?php echo $cacheLifetime; ?>" class="regular-text code" /><span class="setting-description">Enter "0" to disable caching</span></td>
</tr>

<!-- Submit buttons -->
<tr valign="top">
<td colspan="2"><div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;"><input type="submit" name="daves-wordpress-live-search_submit" id="daves-wordpress-live-search_submit" value="Save Changes" /></div></td>
</tr>

</tbody></table>

</form>

<!-- Note -->

<p>Do you find this plugin useful? Consider a donation to <a href="http://catguardians.org">Cat Guardians</a>, a wonderful no-kill shelter where I volunteer.</p>
</div>