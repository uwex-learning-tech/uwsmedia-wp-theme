(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
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
		
	});
	
})(jQuery, this);
