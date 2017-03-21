<?php /* Template Name: Single Column Fixedpage */ ?>

<?php get_header(); ?>

<div class="container">
<div id="primary" class="content-area">
<?php /*?><h1 class="entry-title"><?php single_post_title(); ?></h1>	
<?php */?>
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>

<?php get_footer(); ?>
