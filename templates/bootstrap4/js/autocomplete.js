/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.2
 */
(function($){
    $(document).ready(function() {
        var inputSource = $('#source');    
        var inputDestination = $('#destination');    
        var optionsSource = {
            url: "json/routes.json",
            getValue: function(element) {
    	    	return element.point;
            },
            placeholder: "",
            list: {
                maxNumberOfElements: 100,
                sort: {
                    enabled: false
                },
                match: {
                    enabled: true
                },
		onShowListEvent: function() {
                        var inputDestinationVal = inputDestination.val();
			// console.log('onShowListEvent');
			// console.log(inputDestinationVal);
            		var $listUl = $('.easy-autocomplete-container ul li');
                	$listUl.each(function() {
	                    var currentData = $(this).text();
        	            // console.log(currentData); 
			    if ( currentData == inputDestinationVal ) {
                                $(this).remove();
			    }
                	}); // listLi.each
		},
            },
            minCharNumber: 0
        };
        var optionsDestination = {
            url: "json/routes.json",
            getValue: function(element) {
	    	    return element.point;
            },
            placeholder: "",
            list: {
                maxNumberOfElements: 100,
                sort: {
                    enabled: false
                },
                match: {
                    enabled: true
                },
		onShowListEvent: function() {
                        var inputSourceVal = inputSource.val();
			// console.log('onShowListEvent');
			// console.log(inputSourceVal);
            		var $listUl = $('.easy-autocomplete-container ul li');
                	$listUl.each(function() {
	                    var currentData = $(this).text();
        	            // console.log(currentData); 
			    if ( currentData == inputSourceVal ) {
                                $(this).remove();
			    }
                	}); // listLi.each
		},
            },
            minCharNumber: 0
        };
        inputSource.easyAutocomplete(optionsSource);
        inputDestination.easyAutocomplete(optionsDestination);
	/*
        // $('#source, #destination').easyAutocomplete(options);
        inputSource.on('keyup input', function() {
            var thisVal = $(this).val();
            // console.log(thisVal); 
            var thisValLower = thisVal.toLowerCase();
            var $listUl = $('.easy-autocomplete-container ul li', $(this));
            setTimeout(function () {
                console.log('setTimeout');
                console.log( $listUl.css('display') );
                var $listLi = $('li', $listUl);
                console.log($listLi.html());
                $listUl.each(function() {
                    var currentData = $(this).html();
                    console.log(currentData); 
                }); // listLi.each
            }, 1000); // give some time for population of the list items
        });
	*/
    })
})(jQuery);
