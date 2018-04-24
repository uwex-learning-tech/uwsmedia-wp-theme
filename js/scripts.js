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
		
		// Share On LinkedIn button on Project single page
		jQuery( '#shareOnLinkedIn' ).on( 'click', function( evt ) {
    		
    		window.open( $( this ).data( 'ref' ), '_blank', 'width=500,height=500,menubar=0', false );
    		
    		evt.preventDefault();
    		
		} );
		
	});
	
})(jQuery, this);
