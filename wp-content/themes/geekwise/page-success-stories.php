<?php /* Template Name: Success Stories */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area content-area-fullwidth">
	<main id="main" class="site-main" role="main">
    	<div class="container">
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
		
		<?php
		$query = new WP_Query( array('post_type' => 'success-stories-cpt') );
		?>

		<div class="success-story">
		<?php
		// Start the loop.
		//while ( have_posts() ) : the_post();
		while ( $query->have_posts() ) : $query->the_post();
									
			// Include the page content template.
			get_template_part( 'template-parts/content-page-success-stories', 'page' );
			
			//echo '<p>Class:'. get_post_meta($post->ID, "class", true).'</p>';
			
			//echo '<p>Instructor:'. get_post_meta($post->ID, "instructor", true).'</p>';
			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			
			wp_reset_postdata();
			// End of the loop.
		endwhile;
		?>
        </div>
        
		</div>
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
