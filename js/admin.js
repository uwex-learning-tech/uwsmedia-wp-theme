jQuery( document ).ready( function( $ ) {

	jQuery('#upload_site_logo_button, #upload_footer_logo_button').on('click', function( event ){
    	
    	var self = this;
        var file_frame;
    	
		event.preventDefault();
		
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}
		
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image to upload',
			button: {
				text: 'Use this image',
			},
			multiple: false	// Set to true to allow multiple files to be selected
		});
		
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			
			console.log(event);
			console.log(event.target.id);
			
			if ( event.target.id == 'upload_site_logo_button' ) {
    			$( '#site-logo-preview' ).attr( 'src', attachment.url );
			} else if ( event.target.id == 'upload_footer_logo_button' ) {
    			$( '#footer-logo-preview' ).attr( 'src', attachment.url );
			}
			
			$( '#' + $(self).data('rel') ).val( attachment.url );
			
		});
		
		// Finally, open the modal
		file_frame.open();
		
	});

});





