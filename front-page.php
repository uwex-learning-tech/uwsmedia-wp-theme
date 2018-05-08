<?php get_header(); ?>

<main role="main">
    
    <?php
        $sectionsArray = json_decode( get_option( 'homepage_sections_option' ) );
        foreach ( $sectionsArray as $section ) : ?>
        
        <section class="section-wrapper <?php echo $section->{'accent'}; ?>">
            <div class="container">
                <div class="section-banner">
                    <h2 class="title"><?php echo $section->{'title'}; ?></h2>
                    <p class="description"><?php echo $section->{'text'}; ?></p>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 offset-md-3">
                            <div class="row d-flex justify-content-center">
                        <?php foreach ( $section->{'buttons'} as $button ) : ?>
                        
                        <?php if ( !empty( $button->{'name'} ) ) : 
                        
                                $accent = "btn-outline-dark";
                                
                                if ( $section->{'accent'} == 'dark' ) {
                                    $accent = "btn-outline-light";
                                }
                        
                        ?>
                        
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a class="btn <?php echo $accent; ?> btn-block btn-action" href="<?php echo $button->{'link'}; ?>"><?php echo $button->{'name'}; ?></a>
                                </div>
                        
                        <?php endif; ?>
                        
                        <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="section-bg">
                        <img src="<?php echo $section->{'img'}; ?>" alt="" role="presentation" />
                        </div>
                </div>
            </div>
        </section>
        
        
    <?php endforeach; ?>
	
</main>

<?php get_footer(); ?>
