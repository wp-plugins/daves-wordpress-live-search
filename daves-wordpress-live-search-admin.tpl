<h2>Dave's WordPress Live Search Options</h2>

<form method="post" action="">

<!-- Maximum results -->

<div><label for="user_pics_header_image_sequence"><b>Maximum Results to Display</b></label></div>

<div><input type="text" name="daves-wordpress-live-search_max_results" id="daves-wordpress-live-search_max_results" size="3" value="<?php echo $maxResults; ?>" /></div>

<div><small>Enter "0" to display all matching results</small></div>

<div>
<p><b>Results Direction</b></p>
<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_down" value="down" <?php if($resultsDirection == 'down'): ?>checked="checked"<?php endif; ?>><label for="daves-wordpress-live-search_results_direction_down">Down</input>

<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_up" value="up" <?php if($resultsDirection == 'up'): ?>checked="checked"<?php endif; ?>><label for="daves-wordpress-live-search_results_direction_up">Up</input>
</div>

<div><small>When search results are displayed, in which direction should the results box extend from the search box?</small></div>

<!-- Submit buttons -->

<div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;"><input type="submit" name="daves-wordpress-live-search_submit" id="daves-wordpress-live-search_submit" value="Save Changes" /></div>
</form>

<!-- Note -->

<div class="note">
Please Note: For slightly faster loading times, please consider installing the <a href="http://wordpress.org/extend/plugins/use-google-libraries">Use Google Libraries</a> plugin.
</div>