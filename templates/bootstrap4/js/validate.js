/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.2
 */
(function($){
    $(document).ready(function() {
        var formSearch = $('.form-search');
        formSearch.on('submit', function() {
            var form = this;
            var canSubmit = true;
            $(':input.required', form).each(function() {
                if ( !$(this).val() ) {
                    $(this).addClass('error');
                    canSubmit = false;
                } else {
                    $(this).removeClass('error');
                    canSubmit = true;
                }
            });
            if ( !canSubmit ) {
                alert('The highlighted fields are required');
                return false;
            }
	    var city = $('#city', formSearch).val();
	    var source = $('#source', formSearch).val();
	    var destination = $('#destination', formSearch).val();
	    if ( source == destination ) {
	    	alert('Both Source and Destination can not be the same.');
		return false;
	    }
	    $('.form-search .form-group-swap').show();
	    var url = '?tmpl=component&option=com_content&view=featured&layout=get_bus_route_details&city='+city+'&source='+source+'&destination='+destination;
	    $.get(url, function(responseText){
	        var result = $('<div>').append($.parseHTML(responseText));
	        var busRouteDetailsContents = result.find('#bus_route_details');
                console.log(busRouteDetailsContents.html());
		$('#bus_route_search_results').html( busRouteDetailsContents.html() );
		$('html, body').animate({scrollTop: $('#bus_route_search_results').offset().top-100}, 1000);
            });
            return false;
        })
        $(':input', formSearch).on('blur', function() {
            if ( !$(this).val() ) {
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        })
        $('.swap', formSearch).on('click', function(e) {
	    e.preventDefault();
	    var source = $('#source').val();
	    var destination = $('#destination').val();
	    $('#source', formSearch).val( destination );
	    $('#destination', formSearch).val( source );
        })
    })
})(jQuery);
