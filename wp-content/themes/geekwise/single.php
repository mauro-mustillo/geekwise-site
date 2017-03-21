<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div class="container-fluid no-side-padding">
<div class="container">
<h1 class="entry-title"><?php single_post_title(); ?></h1>	
<div id="primary" class="content-area post-detail col-sm-10 col-sm-push-1">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
		
	

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );
			
			
			echo '<div class="social-media clearfix">';
			echo '<p class="twitter radius5">Twitter<span>20</span></p>';
			echo '<p class="facebook radius5">Facebook<span>1</span></p>';			
			echo '</div>';			
			
			dynamic_sidebar('join-tribe');
			
			dynamic_sidebar('more-reading');


			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ',
				) );
			}
			
			
			
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
</div>
<?php get_footer(); ?>
