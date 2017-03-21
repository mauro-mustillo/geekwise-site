<?php /* Template Name: Mentors */ ?>
<?php get_header(); ?>

<div class="container-fluid no-side-padding">

<div id="primary" class="content-area">
<h1 class="entry-title"><?php single_post_title(); ?></h1>	
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
        

        
		
        <section class='developer-fellows'>
            <div class='container'>

            	<h1 class="col-sm-8 col-sm-push-2">Developer Fellows</h1>
                <div  class="col-sm-10 col-sm-push-1 textblock">
	        		<?php dynamic_sidebar('developer-fellow'); ?>
                </div>
				<?php echo do_shortcode('[ess_grid alias="for-developer-fellows"]'); ?>
		<?php
		/* $query = new WP_Query( array('post_type' => 'developerfellows-cpt','orderby' => 'rand','posts_per_page'=>-1) );		
		?>		
		<?php		
		//echo $query->post_count;
		if ( $query->have_posts() ) :
		?>
			<div class="jcarousel-wrapper">
				<div class="jcarousel">
					<ul>
		<?php
			// Start the loop.
			$j = 0;
			while ( $query->have_posts() ) : $query->the_post();
		
				if($j==0)
				{
				?>
				<li>
				<?php
				}
				
				if($j!=0 && $j % 8 == 0){
				?>
					</li><li>
				<?php
				}
				?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php
			$j++;
			// End of the loop.
			endwhile;
		?>
					</ul>
				</div>
				<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
				<a href="#" class="jcarousel-control-next">&rsaquo;</a>
			</div>
		<?php
		else:  
		?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; */ ?>
        </div>
        </section>
		
        
        <section class='greekwise-instructors'>
        	<div class='container'>
				<h1 class="col-sm-8 col-sm-push-2">Geekwise Instructors</h1>
                <div  class="col-sm-10 col-sm-push-1 textblock">
                	<?php dynamic_sidebar('geekwise-instructors'); ?>
                </div>
                
				<?php echo do_shortcode('[ess_grid alias="for-instructors"]'); ?>
		<?php
		/*$query = new WP_Query( array('post_type' => 'instructor-cpt','orderby' => 'rand','posts_per_page'=>-1) );		
		?>		
		<?php		
		//echo $query->post_count;
		if ( $query->have_posts() ) :
		?>
			<div class="jcarousel-wrapper">
				<div class="jcarousel">
					<ul>
		<?php
			// Start the loop.
			$j = 0;
			while ( $query->have_posts() ) : $query->the_post();
		
				if($j==0)
				{
				?>
				<li>
				<?php
				}
				
				if($j!=0 && $j % 8 == 0){
				?>
					</li><li>
				<?php
				}
				?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php
			$j++;
			// End of the loop.
			endwhile;
		?>
					</ul>
				</div>
				<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
				<a href="#" class="jcarousel-control-next">&rsaquo;</a>
			</div>
		<?php
		else:  
		?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; */ ?>
        
        </div>
        </section>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>

<?php get_footer(); ?>
