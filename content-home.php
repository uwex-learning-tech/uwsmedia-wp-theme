<?php
/**
 * @package UWEX-Media
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("home archive col-sm-12 col-md-6 col-lg-3"); ?>>
<div class="article-wrapper">
	<?php if (has_post_thumbnail()) : ?>
	<div class="featured-thumb col-md-12 col-xs-12">
	<a href="<?php the_permalink(); ?>">
	<?php
		the_post_thumbnail('homepage-banner');
	?>
	</a>
	</div>
	<?php endif; ?>
	<div class="article-rest">
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php uwex_media_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	</div>
</div>
</article><!-- #post-## -->