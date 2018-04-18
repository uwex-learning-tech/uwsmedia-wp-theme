jQuery( document ).ready( function( $ ) {

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

});





