!function(a){a.fn.equalHeights=function(){var b=0,c=a(this);return c.each(function(){var c=a(this).innerHeight();c>b&&(b=c)}),c.css("height",b)},a("[data-equal]").each(function(){var b=a(this),c=b.data("equal");b.find(c).equalHeights()})}(jQuery);

jQuery(document).ready(function() {

	//Set up the Slider
	if (jQuery(window).width() > 991 ) {
		setTimeout(function() {
			for (var i = 0; i < 15; i++) {
				jQuery('#primary-home .row-'+i+' article').equalHeights();
				}
	      }, 1250);
	 }

	jQuery('.main-navigation .menu ul').superfish({
			delay:       1000,                            // 1 second avoids dropdown from suddenly disappearing
			animation:   {opacity:'show'},  			  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  false                            // disable generation of arrow mark-up
		});

	jQuery('.menu-toggle').toggle(function() {
		jQuery('#site-navigation ul.menu').slideDown();
		jQuery('#site-navigation div.menu').fadeIn();
	},
	function() {
		jQuery('#site-navigation ul.menu').slideUp( function() {
    		jQuery( "#site-navigation" ).removeClass( 'toggled' );
		} );
		jQuery('#site-navigation div.menu').hide();
	});

	if (jQuery(window).width() > 992 ) {
		       //  jQuery('#primary-home article').css( 'height', jQuery(this).parent('.row').height() );
		       //  jQuery('#primary-home article').css( 'height', jQuery(this).parent('.row').height() );
	       }

    jQuery('.toc_widget').affix({
      offset: {
        top: 120,
        bottom: function() {
          return (this.bottom = jQuery('#footer-sidebar').outerHeight(true));
        }
      }
    });

});

jQuery(window).resize( function() {

    var menu = jQuery( '#site-navigation ul.menu' );

    if ( jQuery(this).width() >= 767 ) {

        menu.show();

    } else {

        if ( !jQuery( "#site-navigation" ).hasClass( 'toggled' ) ) {
            menu.hide();
        }


    }

} );