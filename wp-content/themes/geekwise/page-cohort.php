<?php /* Template Name: Cohort */ ?>

<?php get_header(); ?>

<div class="container-fluid no-side-padding">

<div id="primary" class="content-area">
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
		
		<section class="container-fluid cohort-wrapper"> 
        	<h1>The Geekwise Academy Cohort Programs</h1>       
        	<div class="container">
				<?php echo do_shortcode('[ess_grid alias="cohort"]'); ?>
            </div>
        </section>
        
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>

<?php get_footer(); ?>
