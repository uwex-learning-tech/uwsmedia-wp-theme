<?php get_header(); ?>

<main role="main">
	
	<!-- section -->
	<section style="background-color: red; min-height: 250px;">
    	
        <div class="container">
            
            <div id="hero">Hero Carousel</div>
            
        </div>

	</section>
	<!-- /section -->
	
	<?php
    	
    	$sectionsArray = json_decode( get_option( 'homepage_sections_option' ) );
    	
    	foreach ($sectionsArray as $section) {
            
            $sectionHtmls = '<section class="section-wrapper '.$section->{'accent'}.'">';
            $sectionHtmls .= '<div class="container"><div class="section-banner">';
            
            $sectionHtmls .= '<h2 class="title">'.$section->{'title'}.'</h2>';
            
            $sectionHtmls .= '<p class="description">'.$section->{'text'}.'</p><div class="buttons">';
            
            foreach ( $section->{'buttons'} as $button ) {
                
                if ( !empty($button->{'name'}) ) {
                    
                    $sectionHtmls .= '<a class="btn" href="'.$button->{'link'}.'">'.$button->{'name'}.'</a>';
                    
                }
                
            }
            
            $sectionHtmls .= '</div><div class="section-bg"><img src="'.$section->{'img'}.'" alt="" role="presentation" /></div></div></div></section>';
            
            echo $sectionHtmls;
            
        }
    	
    ?>
	
</main>

<?php get_footer(); ?>
