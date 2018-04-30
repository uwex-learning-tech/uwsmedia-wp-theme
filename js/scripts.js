(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// Copy Link button on Project single page
		jQuery( '#copy-share-link' ).on( 'click', function( evt ) {
    		
    		$( this ).find( '.hiddenShareLink' )[0].select();
    		
    		document.execCommand( 'Copy' );
    		
    		$( this ).find( '.hiddenShareLink' )[0].blur();
    		
    		$( '.sharings .msg' ).html( 'Link copied!' ).fadeIn( function () {
        		
        		setTimeout( function() {
        		
            		$( '.sharings .msg' ).fadeOut( function () {
                		
                		$( this ).html( '' );
                		
            		} );
            		
        		}, 3000 );
        		
    		} );
    		
    		evt.preventDefault();
    		
		} );
		
		jQuery( document ).on( 'click', '#shareSearchLink', function( evt ) {
    		
    		var self = this;
    		
    		$( self ).find( '.hiddenShareLink' )[0].select();
    		
    		document.execCommand( 'Copy' );
    		$( $( self ).find( '.txt' )[0] ).html( 'Link copied!' );
    		
    		$( self ).find( '.hiddenShareLink' )[0].blur();
    		
    		setTimeout( function() {
        		
        		$($( self ).find( '.txt' )[0]).html( 'Copy Seach Link' );
        		
    		}, 3000 );
    		
    		evt.preventDefault();
    		
		} );
		
		// Share On LinkedIn button on Project single page
		jQuery( '#shareOnLinkedIn' ).on( 'click', function( evt ) {
    		
    		window.open( $( this ).data( 'ref' ), '_blank', 'width=500,height=500,menubar=0', false );
    		
    		evt.preventDefault();
    		
		} );
		
		// live search
    	jQuery( '#ajax-search-btn' ).on( 'click', function( evt ) {
        	
        	var query = jQuery( '#ajax-search-input' ).val();
        	var postId = jQuery( 'input[name=post_id]' ).val();
        	var contentArea = jQuery( '#projects-archive' );
        	
        	if ( query.length >= 1 ) {
            	
            	jQuery.ajax( {
            	
                	type: 'post',
                	url: ajaxSearch.ajaxurl,
                	data: {
                    	action: 'load_search_results',
                    	query: query,
                    	security: ajaxSearch.ajax_nonce,
                    	post_id: postId
                	},
                	beforeSend: function() {
                    	
                	},
                	success: function( response ) {
                    	contentArea.html( response );
                	}
                	
            	} );
            	
        	}
            
        	evt.preventDefault();
        	
    	} );
    	
    	jQuery( '#ajax-search-input' ).bind( 'enterKey', function() {
        	
        	jQuery( '#ajax-search-btn' ).trigger( 'click' );
        	
    	} );
    	
    	jQuery( '#ajax-search-input' ).keyup( function( evt ) {
        	
        	if ( evt.keyCode == 13 ) {
            	
            	jQuery( this ).trigger( 'enterKey' );
            	
        	}
        	
    	} );
    		
	});
	
})(jQuery, this);
