jQuery( document ).ready( function( $ ) {
    
    if ( !jQuery( 'body' ).hasClass( 'post-new-php' ) && !jQuery( 'body' ).hasClass( 'post-php' ) && !jQuery( 'body' ).hasClass( 'edit-php' ) ) {
    
        var imageUploadSelectors = '#upload_site_logo_button, #upload_footer_logo_button, #section-one-img, #section-two-img, #section-three-img';
        
    	jQuery(imageUploadSelectors).on('click', function( event ){
        	
        	var self = this;
            var file_frame;
        	
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
    			
    			console.log($(self).data('preview'));
    			
    			attachment = file_frame.state().get('selection').first().toJSON();
    			
    			$( '#' + $(self).data('preview') ).attr( 'src', attachment.url );
    			$( '#' + $(self).data('rel') ).val( attachment.url );
    			
    		});
    		
    		file_frame.open();
    		
    	});
    	
    	jQuery( '#save-section-button' ).on('click', handleSectionObjString);
    	jQuery( '#homepage-sections input, #homepage-sections textarea' ).on('blur', handleSectionObjString);
    	
    	function handleSectionObjString() {
        	
        	var sections =  jQuery( '#homepage-sections' ).find( '.section' );
        	var sectionObjArray = [];
        	var numbers = ['one', 'two', 'three'];
        	
        	jQuery.each( sections, function(i) {
            	
            	var self = this;
            	var obj = {};
            	
            	obj.img = $(this).find( '.uwsimgurl' ).val();
            	obj.text = $(this).find( '.uwstextarea' ).val();
            	obj.title = $(this).find( '.uwstitle' ).val();
            	
            	var buttons = $(this).find( '.uwsbtn' );
            	var links = $(this).find( '.uwsbtnlink' );
            	
            	obj.buttons = [];
            	
            	jQuery.each( buttons, function( i ) {
                	
                	var btnObj = {};
                	
                	btnObj.name = $(this).val();
                	btnObj.link = $(links[i]).val();
                	
                	obj.buttons.push(btnObj);
                	
            	} );
            	
            	obj.accent = $(this).find('input[name=section-'+numbers[i]+'-accent]:checked').val();
            	
            	sectionObjArray.push( obj );
            	
        	} );
        	
        	$( '#homepage_sections_option' ).val(JSON.stringify(sectionObjArray));
        	
    	}
	
	}
	
	if ( jQuery( 'body' ).hasClass( 'wp-admin')
	&& jQuery( 'body' ).hasClass( 'post-type-uws-projects' ) && !jQuery( 'body' ).hasClass( 'post-php' ) && !jQuery( 'body' ).hasClass( 'edit-php' ) && !jQuery( 'body' ).hasClass( 'post-new-php' ) ) {
    	
    	// check if the group box has faculty checked
    	var groupSelect = '#poststuff select#post_group_id';
    	
    	if ( $( groupSelect + ' option:selected' ).text().toLowerCase() === 'faculty' ) {
        	
        	$( '#toPortfolio' ).show();
        	
    	}
    	
    	jQuery( groupSelect ).change( function() {
        	
        	var target = $(this).find('option:selected').text().toLowerCase();
        	
        	if ( target === 'faculty' ) {
            	
            	$( '#toPortfolio' ).show();
            	
        	} else {
            	
            	$( '#toPortfolio' ).hide();
            	$( '#promote_to_porfolio' ).prop( 'checked', false );
        	}
        	
    	} );
    	
    	var authorsInput = jQuery( 'input[name=project_authors]' );
    	
    	if ( authorsInput.val().length ) {
        	
        	var authors = authorsInput.val().split( ',' );
    	
        	jQuery.each( authors, function( i ) {
            	
            	$( 'select[name=project_authors_select] option[value=' + authors[i] + ']' ).prop( 'selected', true );
            	
        	} );
        	
    	}
    	
    	// get the value of the multiple select input
    	jQuery( 'select[name=project_authors_select]' ).on( 'change', function() {
        	
        	var values = $( this ).val().join( ',' );
    
        	authorsInput.val( values );
        	
    	} );
    	
	}

});





