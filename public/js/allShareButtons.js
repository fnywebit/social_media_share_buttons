FNYShareButtons = {};

FNYShareButtons.deleteSocialButtons = function(id) {
	var csrf_token = jQuery("#fny-delete-ajax-nonce").val();
	var data = {
		action: 'delete_share_buttons',
		_ajax_nonce: csrf_token,
		id: id
	}

	jQuery.post(ajaxurl, data, function(response) {
		if (response == "success") {
			location.reload();
		}
		else {
			alert("Something went wrong. Cannot delete social buttons");
		}
	});
}
