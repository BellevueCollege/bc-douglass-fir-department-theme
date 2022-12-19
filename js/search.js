/**
 * Search Script Used when Custom Search Settings are Configured
 */

 // Make sure variables are being passed in
if ( typeof limit_searchform_scope !== 'undefined' ||
	 typeof search_api_key         !== 'undefined' ||
	 typeof filter_value           !== 'undefined' ||
	 typeof search_field_id        !== 'undefined' ||
	 typeof custom_search_url      !== 'undefined' ||
	 typeof search_url_default     !== 'undefined' ) {

	(function ($) {
		// Double check this should run
		if ( limit_searchform_scope ) {

			/* Generate search URL in dropdown */
			$('#college-search-site-link').click( function( event ) {

				// Default action is to simply go to search page, if no JS
				event.preventDefault();

				// Submit
				$('#bc-search').submit();
			});

			$('#college-search-all-link').click( function( event ) {
				/* Default action is to simply go to search page, if no JS */
				event.preventDefault();

				// Remove filters and reset action URL
				$('.college-search-filter').remove();
				$('#bc-search').attr('action', search_url_default);

				// Build a second instance of the search history object, to so history appears on main
				$('#bc-search-container-lite').searchHistory({
					field: '#college-search-field-custom'
				});

				// Submit
				$('#bc-search').submit();
			});

		}
	})(jQuery);
}
