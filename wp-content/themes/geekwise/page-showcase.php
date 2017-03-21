<?php /* Template Name: Showcase */ ?>

<?php get_header(); ?>

<div class="container">

<div id="primary" class="content-area content-showcase">
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
		
		<?php		
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$query = new WP_Query( array('post_type' => 'showcase-cpt','posts_per_page' => 1,'paged' => $paged) );		
		?>		
		<div class="showcase">
			<?php 
			if ( $query->have_posts() ) :
				// Start the loop.		
				//while ( have_posts() ) : the_post();		
				while ( $query->have_posts() ) : $query->the_post(); 
				
				// Include the page content template.			
				get_template_part( 'template-parts/content-page-showcase', 'page' );					
				
				//echo '<p>Class:'. get_post_meta($post->ID, "class", true).'</p>';
				
				//echo '<p>Instructor:'. get_post_meta($post->ID, "instructor", true).'</p>';
				
				// If comments are open or we have at least one comment, load up the comment template.			
				if ( comments_open() || get_comments_number() ) {				
					comments_template();
				}						
									
				// End of the loop.		
				endwhile;		
			
				// pagination
				/*next_posts_link( 'Older Entries', $query->max_num_pages );
				previous_posts_link( 'Newer Entries' );*/
				
				pagination_bar($query->max_num_pages);
				
				wp_reset_postdata();
			else:  
			?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>	
		</div>
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>

<?php get_footer(); ?>
