/*
 * WordPress wouldnt update some duick edit fields automatically, so we need to force.
 */
jQuery(document).ready(function() {
	jQuery('#the-list').on('click', '.editinline', function() {
		var tag_id = jQuery(this).parents('tr').attr('id');
		var radios = jQuery('input[name=hide_singular_title]', '#' + tag_id);
		var cheked_item = 0;
		for ( var i = 0; i < radios.length; i++) {
			var html_str = radios[i].outerHTML;
			if (html_str.indexOf('checked') > 0) {
				cheked_item = i;
			}
		}
		jQuery(':input[value="' + cheked_item + '"]', '.inline-edit-row').attr('checked', 'checked');
	});
});