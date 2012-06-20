var MyDialogs = {
	loadConfirmationModal : function(modalId, confirmURL, caption, body) {
		var $modal = jQuery('#' + modalId);
		if ($modal.size() === 0) {
			var modalString = '<div id="'
					+ modalId
					+ '" class="modal hide fade">'
					+ '<div class="modal-header">'
					+ '<button class="close" data-dismiss="modal">x</button>'
					+ '<h3>'
					+ caption
					+ '</h3>'
					+ '</div>'
					+ '<div class="modal-body">'
					+ body
					+ '</div>'
					+ '<div class="modal-footer">'
					+ '<button id="cancel" class="btn" data-dismiss="modal" type="button" name="cancel">Cancel</button>'
					+ '<a id="submit" class="btn btn-danger" href="'
					+ confirmURL + '">Delete</a>' + '</div>' + '</div>';
			$modal = jQuery(modalString);
		}
		$modal.modal('show');
		return false;
	}
};