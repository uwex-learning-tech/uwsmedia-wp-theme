jQuery( document ).ready( function( $ ) {
    
    if ( !jQuery( 'body' ).hasClass( 'post-new-php' ) && !jQuery( 'body' ).hasClass( 'post-php' ) && !jQuery( 'body' ).hasClass( 'edit-php' ) ) {
    
        let imageUploadSelectors = '#upload_site_logo_button, #upload_footer_logo_button';
        
    	jQuery(imageUploadSelectors).on('click', function( event ){
        	
        	let self = this;
            let file_frame;
        	
    		event.preventDefault();
    		
    		// Create the media frame.
    		file_frame = wp.media.frames.file_frame = wp.media({
    			title: 'Select a image to upload',
    			button: {
    				text: 'Use this image',
    			},
    			multiple: false
    		});
    		
    		// When an image is selected, run a callback.
    		file_frame.on( 'select', function() {
    			
    			attachment = file_frame.state().get('selection').first().toJSON();
    			
    			$( '#' + $(self).data('preview') ).attr( 'src', attachment.url );
    			$( '#' + $(self).data('rel') ).val( attachment.url );
    			
    		});
    		
    		file_frame.open();
    		
    	});
	
	}
	
	if ( jQuery( 'body' ).hasClass( 'wp-admin') && (jQuery( 'body' ).hasClass( 'post-type-uws-projects' ) || jQuery( 'body' ).hasClass( 'post-type-uws-flex-projects' ) || jQuery( 'body' ).hasClass( 'post-type-marketing-projects' ))) {
    	
		let postTypeGroupRegex = null;

		if ( jQuery( 'body' ).hasClass( 'post-type-uws-projects' ) ) {
			postTypeGroupRegex =  new RegExp(/collab(orative)? showcase/, 'gi');
		} else if ( jQuery( 'body' ).hasClass( 'post-type-uws-flex-projects' ) ) {
			postTypeGroupRegex =  new RegExp(/flex(ible)?|(comp(etency)?(-based)?) showcase/, 'gi');
		} else if ( jQuery( 'body' ).hasClass( 'post-type-marketing-projects' ) ) {
			postTypeGroupRegex =  new RegExp(/marketing showcase/, 'gi');
		}

		if ( postTypeGroupRegex ) {
			
			if ( $( "#post_group_id" ).val() == -1 ) {
				
				$( "#post_group_id option" ).each( function() {
					
					if ( $(this).text().search( postTypeGroupRegex ) >= 0 ) {
						$( "#post_group_id" ).val($(this).val());
						return false;
					}
					
				} );

			}

		}

    	let authorsInput = jQuery( 'input[name=project_authors]' );
    	
    	if ( authorsInput.length ) {
        	
        	if ( authorsInput.val().length ) {
        	
            	let authors = authorsInput.val().split( ',' );
        	
            	jQuery.each( authors, function( i ) {
                	$( 'select[name=project_authors_select] option[value=' + authors[i] + ']' ).prop( 'selected', true );
            	} );
            	
        	}
        	
        	// get the value of the multiple select input
        	jQuery( 'select[name=project_authors_select]' ).on( 'change', function() {
            	
            	let values = $( this ).val().join( ',' );
            	authorsInput.val( values );
            	
        	} );
        	
    	}
    	
	}

	if ( jQuery( 'body' ).hasClass( 'wp-admin') && jQuery( 'body' ).hasClass( 'post-type-uws-groups' ) ) {
		jQuery('#group-color-picker').wpColorPicker();
	}
	
});





