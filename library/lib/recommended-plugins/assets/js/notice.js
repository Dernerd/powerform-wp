(function ($, window) {
	var notice     = $('.psource-recommended-plugins'),
	    selectorEl = notice.data('selectorEl'),
	    selectorFn = notice.data('selectorFn');

	// customize placement
	if ('' !== selectorEl && '' !== selectorFn) {
		try {
			$.fn[selectorFn].call($(selectorEl), notice);
		} catch (e) {
		}
	}
	notice.show();

	$('.psource-recommended-plugins .dismiss').on('click', function (e) {
		var pointer = $(this).data('pointer'),
		    action  = $(this).data('action');

		e.preventDefault();

		if (window.ajaxurl) {
			$.ajax({
				url: window.ajaxurl,
				method: 'POST',
				data: {
					pointer: pointer,
					action: action,
				},
			}).always(function () {
				// ALWAYS CLOSE WHATEVER AJAX RESULT
				removeNotice();
			});
		} else {
			// ALWAYS CLOSE EVEN AJAX NOT POSSIBLE
			removeNotice();
		}

		return false;
	});

	function removeNotice() {
		$('.psource-recommended-plugins').remove();
	}

}(jQuery, window));
