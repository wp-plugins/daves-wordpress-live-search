jQuery(document).ready(function($){

	function dwls_admin_color_change() {
		setTimeout(function() {
			var input = $(this),
			preview = $('#dwls_design_preview ul.search_results');
			$('#dwls_custom_styles').remove();
			$('body').append([
				'<style type="text/css" id="dwls_custom_styles">',
	            '#dwls_design_preview ul.search_results li {',
	            '  color: ' + $('#daves-wordpress-live-search_custom_fg').val() + ';',
	            '  background-color: ' + $('#daves-wordpress-live-search_custom_bg').val() + ';',
	            '}',
	            '#dwls_design_preview .search_footer {',
	            '  background-color: ' + $('#daves-wordpress-live-search_custom_footbg').val() + ';',
	            '}',
	            '#dwls_design_preview .search_footer a,',
	            '#dwls_design_preview .search_footer a:visited {',
	            '  color: ' + $('#daves-wordpress-live-search_custom_footfg').val() + ';',
	            '}',
	            '#dwls_design_preview ul.search_results li a, #dwls_design_preview ul.search_results li a:visited {',
	            '  color: ' + $('#daves-wordpress-live-search_custom_title').val() + ';',
	            '}',
	            '#dwls_design_preview ul.search_results li:hover',
	            '{',
	            '  background-color: ' + $('#daves-wordpress-live-search_custom_hoverbg').val() + ';',
	            '}',
				'</style>'].join("\n"));
		}, 0);
	}

	$('.dwls_color_picker').change(dwls_admin_color_change);
    $('.dwls_color_picker').wpColorPicker({change: dwls_admin_color_change});
    dwls_admin_color_change();
});