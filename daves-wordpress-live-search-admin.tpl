<div class="wrap">
<h2>Dave's WordPress Live Search Options</h2>

<form method="post" action="">

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

</div>