( function( $, root, undefined ) {
	
	$( function() {
		
		'use strict';
		
		/***********************************************************************
		 SINGLE UWS PROJECTS FUNCTIONS
		***********************************************************************/
		
		if ( jQuery( 'body ').hasClass( 'single-uws-projects' ) ) {
    		
    		// copy link button
    		jQuery( '#copy-share-link' ).on( 'click', function( evt ) {
        		
        		// prevent default link interaction behavior
        		evt.preventDefault();
        		
        		// set variables to DOM elements
        		var hiddenInput = $( this ).find( '.hiddenShareLink' )[0];
        		var msgDisplay = $( '.share.msg' );
        		var msg = 'Linked copied!';
        		
        		// select the text in the hidden input field
        		// copy it to the clipboard
        		// unfocus the hideen input field
        		hiddenInput.select();
        		document.execCommand( 'copy' );
        		hiddenInput.blur();
        		
        		// display message to the DOM; hide message after 3 seconds
        		msgDisplay.html( msg ).fadeIn( function() {
            		
            		setTimeout( function() {
            		
                		msgDisplay.fadeOut( function() {
                    		
                    		$( this ).html( '' );
                    		
                		} );
                		
            		}, 3000 );
            		
        		} );
        		
    		} ); // end function
    		
    		// share on LinkedIn button
    		jQuery( '#shareOnLinkedIn' ).on( 'click', function( evt ) {
        		
        		// prevent default link interaction behavior
        		evt.preventDefault();
        		
        		// set the URL from the button's data-ref attribute
        		var url = $( this ).data( 'ref' );
        		
        		// open the URL in a new browser window with additional specification
        		window.open( url, '_blank', 'width=500,height=500,menubar=0', false );
        		
    		} ); // end function
    		
		} // end single uws projects conditional check
		
		/***********************************************************************
		 PAGE SHOWCASE FUNCTIONS
		***********************************************************************/
		
		if ( jQuery( 'body' ).hasClass( 'page-template-page-showcase' ) ) {
    		
    		runSearch();
    		
    		// share search result link button
    		// filter the selector to the button's ID due to dynamic loading
    		jQuery( document ).on( 'click', '#shareSearchLink', function( evt ) {
        		
        		// prevent default link interaction behavior
        		evt.preventDefault();
        		
        		// set variables to DOM elements
        		var hiddenInput = $( this ).find( '#hiddenSearchLink' )[0];
        		var textDisplay = $( this ).find( '.txt' )[0];
        		var msg = 'Copied to Clipboard!';
        		var originalMsg = 'Share Search Link';
        		
        		// select the text in the hidden input field
        		// copy it to the clipboard
        		// unfocus the hideen input field
        		hiddenInput.select();
        		document.execCommand( 'Copy' );
        		hiddenInput.blur();
        		
        		// display the message
        		$( textDisplay ).html( msg );
                
                // revert the message back to the original after 3 seconds
        		setTimeout( function() {
            		
            		$( textDisplay ).html( originalMsg );
            		
        		}, 3000 );
        		
    		} ); // end function
    		
    		// AJAX search
    		jQuery( '#ajaxSearchBtn, .form-check-input' ).on( 'click', function() {
        		
        	    if ( !runSearch() ) {
            	    window.location.reload();
        	    }
            	
        	} );
        	
        	// added enter key event to trigger search button click
        	jQuery( '#ajaxSearchInput' ).bind( 'enterKey', function() {
            	
            	jQuery( '#ajaxSearchBtn' ).trigger( 'click' );
            	
        	} );
        	
        	// trigger enterKey event when enter key is pressed
        	jQuery( '#ajaxSearchInput' ).keyup( function( evt ) {
            	
            	if ( evt.keyCode == 13 ) {
                	
                	jQuery( this ).trigger( 'enterKey' );
                	
            	}
            	
        	} );
        	
        	function runSearch() {
    		
        		// set variable to DOM elements
            	var searchInput = jQuery( '#ajaxSearchInput' ).val().trim();
            	var postId = jQuery( 'input[name=postId]' ).val();
            	var programCBs = jQuery( '.sidebarFilter .program-cb:checked' );
            	var classCBs = jQuery( '.sidebarFilter .classification-cb:checked' );
            	var mediaCBs = jQuery( '.sidebarFilter .media-cb:checked' );
            	var resultsDisplay = jQuery( '#projects-archive' );
                
                // set AJAX request data
                var args = {
                    action: 'load_search_results',
                    security: ajaxSearch.ajax_nonce,
                    post_id: postId,	
            	};
            	
            	// add search input if not empty
            	if ( searchInput.length ) {
                	
                	args.query = searchInput;
                	
            	}
                
                // add program tags if checked
            	if ( programCBs.length ) {
                	
                	var tags = [];
                    
                    programCBs.each( function() {
                	
                    	tags.push( jQuery( this ).val() )
                    	
                	} );
    
                    args.programTags = tags.join( ',' );
                	
            	}
            	
            	// add classification tags if checked
            	if ( classCBs.length ) {
                	
                	var tags = [];
                    
                    classCBs.each( function() {
                	
                    	tags.push( jQuery( this ).val() )
                    	
                	} );
                    
                    args.classTags = tags.join( ',' );
                	
            	}
                
                // add media type tags if checked
                if ( mediaCBs.length ) {
                	
                	var tags = [];
                    
                    mediaCBs.each( function() {
                	
                    	tags.push( jQuery( this ).val() )
                    	
                	} );
                    
                    args.mediaTags = tags.join( ',' );
                	
            	}
            	
            	if ( mediaCBs.length || classCBs.length || programCBs.length || searchInput.length ) {
                	
                	// execute AJAX
                	jQuery.ajax( {
                    	
                    	type: 'POST',
                    	url: ajaxSearch.ajaxurl,
                    	data: args,
                    	success: function( response ) {
                        	
                        	resultsDisplay.html( response );
                        	
                    	}
                    	
                	} );
                	
                	return true;
                	
            	}
            	
            	return false;
            	
    		}
    		
		} // end page showcase conditional check
		
		
		/***********************************************************************
		 MEMBER PROJECT AJAX SEARCH
		***********************************************************************/
		
		if ( jQuery( 'body' ).hasClass( 'single-uws-team-members' ) ) {
    		
    		getProjects();
    		
        	function toPage( page ) {
            	
            	getProjects( page );
            	
        	}
        	
        	function getProjects( page ) {
            	
            	page = (typeof page !== 'undefined') ?  page : null;
            	
            	var resultsDisplay = jQuery( '#member-projects' );
        		var postId = jQuery( 'input[name=post_id]' ).val();
        		var args = {
                    action: 'load_member_projects',
                    security: ajaxSearch.ajax_nonce,
                    post_id: postId,	
            	};
            	
            	if ( page ) {
                	
                	args.page_num = page;
                	
            	}
            	
            	jQuery.ajax( {
                        	
                	type: 'POST',
                	url: ajaxSearch.ajaxurl,
                	data: args,
                	success: function( response ) {
                    	
                    	resultsDisplay.html( response );
                    	
                    	var paginateLinks = jQuery( 'a.page-numbers' );
            	
                        if ( paginateLinks.length ) {
                            
                            jQuery.each( paginateLinks, function( i ) {
                                
                                var href = jQuery( paginateLinks[i] ).attr( 'href' );
                                var startPos = href.indexOf( '=' ) + 1;
                                var num = href.substr( startPos );
                                
                                jQuery( paginateLinks[i] ).attr( 'data-page', num );
                                
                            } );
                            
                        }
                        
                        paginateLinks.on( 'click', function( evt ) {
                            
                            toPage( $( evt.currentTarget ).data( 'page' ) );
                            evt.preventDefault();
                            
                        } );
                    	
                	}
                	
            	} );
            	
        	}

		}
	
	} ); // end DOM ready function
	
} )( jQuery, this );
