<?php 
    get_header();
    $postType = get_queried_object();
 ?>
    
<div class="container">
      
    <main role="main">
        <h1><?php echo $postType->labels->name; ?></h1>
        <?php get_template_part('loop'); ?>
    </main>

    
</div>

<?php get_footer(); ?>
