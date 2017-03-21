<?php /* Template Name: Home Page */ ?>

<?php get_header('front-page'); ?>

<div class="container-fluid no-side-padding">


<h1 class="entry-title"><span><?php the_title(); ?></span></h1> 
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
       <div class="home-instructors-back"> 
        <div class="container">
        <section class="home-instructors col-sm-12">
        	<h1>Not Your Average Instructors</h1>            
			<?php
				echo do_shortcode('[ess_grid alias="mentors"]'); 
			/*$query = new WP_Query( array('post_type' => 'mentors-cpt', 'orderby' => 'rand', 'posts_per_page' => 8) );	
			
			if ( $query->have_posts() ) :
				// Start the loop.			
				?>
				<ul>
				<?php
				while ( $query->have_posts() ) : $query->the_post();
				?>
				<li class="col-xs-6 col-sm-3"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php twentysixteen_post_thumbnail(); ?></a></li>
				<?php
				// End of the loop.		
				endwhile;
			else:  
			?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; */ ?>
        </section>
        </div></div>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
</div>
<?php get_footer('home'); ?>
