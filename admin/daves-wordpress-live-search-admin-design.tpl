<?php include dirname(__FILE__)."/admin_header.tpl"; ?>
<h2>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=settings"; ?>" class="nav-tab"><?php _e("Settings", 'dwls'); ?></a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=design"; ?>" class="nav-tab nav-tab-active"><?php _e("Design", 'dwls'); ?></a>
<a href="<?php echo $_SERVER['REQUEST_URI']."&tab=advanced"; ?>" class="nav-tab"><?php _e("Advanced", 'dwls'); ?></a>
<?php if($enableDebugger) : ?><a href="<?php echo $_SERVER['REQUEST_URI']."&tab=debug"; ?>" class="nav-tab"><?php _e("Debug", 'dwls'); ?></a><?php endif; ?>
</h2>
<form method="post" action="">
<input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>" />

<?php
if ( function_exists('wp_nonce_field') )
	wp_nonce_field('daves-wordpress-live-search-config');
?>

<table class="form-table"><tbody>

<!-- CSS styles -->
<tr valign="top">
<td colspan="2"><h3><?php _e("Styles", 'dwls'); ?></h3></td>
</tr>

<tr valign="top">
<th scope="row"> </th>
<td>
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_gray" value="default_gray" <?php if('default_gray' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_default_gray"><?php _e("Default Gray", 'dwls'); ?></label><br /><span class="setting-description"><?php _e("Default style in gray.", 'dwls'); ?></span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_red" value="default_red" <?php if('default_red' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_default_red"><?php _e("Default Red", 'dwls'); ?></label><br /><span class="setting-description"><?php _e("Default style in red", 'dwls'); ?></span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_default_blue" value="default_blue" <?php if('default_blue' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_default_blue"><?php _e("Default Blue", 'dwls'); ?></label><br /><span class="setting-description"><?php _e("Default style in blue", 'dwls'); ?></span>
<br /><br />

<?php if($color_picker_supported) : ?>

<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_custom" value="custom" <?php if('custom' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_custom"><?php _e("Custom", 'dwls'); ?></label><br /><span class="setting-description"><?php _e("Choose your colors below.", 'dwls'); ?></span>

<div id="custom_colors" style="display:none;">
<div id="custom_colors_options">

<div><label><?php _e("Title", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[title]" id="daves-wordpress-live-search_custom_title" value="<?php if(!empty($customOptions['title'])) echo $customOptions['title']; ?>" data-default-color="#000" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>

<div><label><?php _e("Excerpt", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[fg]" id="daves-wordpress-live-search_custom_fg" value="<?php if(!empty($customOptions['fg'])) echo $customOptions['fg']; ?>" data-default-color="#000" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>

<div><label><?php _e("Background", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[bg]" id="daves-wordpress-live-search_custom_bg" value="<?php if(!empty($customOptions['bg'])) echo $customOptions['bg']; ?>" data-default-color="#ddd" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>

<div><label><?php _e("Hover Background", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[hoverbg]" id="daves-wordpress-live-search_custom_hoverbg" value="<?php if(!empty($customOptions['hoverbg'])) echo $customOptions['hoverbg']; ?>" data-default-color="#fff" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>

<div><label><?php _e("Footer Background", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[footbg]" id="daves-wordpress-live-search_custom_footbg" value="<?php if(!empty($customOptions['footbg'])) echo $customOptions['footbg']; ?>" data-default-color="#888" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>

<div><label><?php _e("Footer Text", 'dwls'); ?></label><input type="text" name="daves-wordpress-live-search_custom[footfg]" id="daves-wordpress-live-search_custom_footfg" value="<?php if(!empty($customOptions['footfg'])) echo $customOptions['footfg']; ?>" data-default-color="#fff" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" /></div>
</div>

<div id="dwls_design_preview">
<ul class="search_results" style="display: block;"><input type="hidden" name="query" value="sample"><li class="daves-wordpress-live-search_result"><a href="#" class="daves-wordpress-live-search_title">Sample Page</a><p class="excerpt clearfix"></p><p>This is an example page. It’s different from a blog post because it will stay in one place and will [...]</p> <p></p><p class="meta clearfix" id="daves-wordpress-live-search_author">Posted by Admin</p><p id="daves-wordpress-live-search_date" class="meta clearfix">December 5, 2012</p><div class="clearfix"></div></li><div class="clearfix search_footer"><a href="#">View more results</a></div></ul>
</div>
</div>
<br /><br />

<?php endif; ?>

<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_theme" value="theme" <?php if('theme' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_theme"><?php _e("Theme-specific", 'dwls'); ?></label><br /><span class="setting-description"><strong><?php _e("For advanced users", 'dwls'); ?>:</strong> <?php _e("Theme must include a CSS file named daves-wordpress-live-search.css. If your theme does not have one, copy daves-wordpress-live-search_default_gray.css from this plugin's directory into your theme's directory and modify as desired.", 'dwls'); ?></span>
<br /><br />
<input type="radio" name="daves-wordpress-live-search_css" id="daves-wordpress-live-search_css_existing_theme" value="notheme" <?php if('notheme' == $cssOption): ?>checked="checked"<?php endif; ?> /> <label for="daves-wordpress-live-search_css_theme"><?php _e("Theme-specific (theme's own CSS file)", 'dwls'); ?></label><br /><span class="setting-description"><strong><?php _e("For advanced users", 'dwls'); ?>:</strong> <?php _e("Use the styles contained within your Theme's stylesheet. Don't include a separate stylesheet for Live Search.", 'dwls'); ?>
</td> 
</tr>

<!-- Submit buttons -->
<tr valign="top">
<?php $saveButtonText = __("Save Changes", 'dwls'); ?>
<td colspan="2"><div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;"><input type="submit" name="daves-wordpress-live-search_submit" id="daves-wordpress-live-search_submit" value="<?php echo $saveButtonText; ?>" /></div></td>
</tr>

</tbody></table>

</form>

<?php include dirname(__FILE__)."/admin_footer.tpl"; ?>
</div>