<?php
/**
 *  This file will display all the "Series" types.
 *  These currently include
 *   - Professional Geek Series
     -- Freelancing for beginners
     -- How to Job
 *
 * 
 */

    global $post;
    $page_requested=$post->post_name;

	$freelancing_for_geeks 		= get_post(758);
	$job_stuff_for_geeks		= get_post(759);



get_header(); ?>



<div class="container">
<div id="primary" class="content-area row">
	<main id="main" class="site-main" role="main">
    
        <div class="welcome welcome-courses clearfix">
        	<h1>
        		<?php 
        			single_cat_title();
				?>
			</h1>
            <div class="col-md-10 col-md-offset-1">
            	<p>
            		
           		 	<?php echo category_description( $category_slug_id = get_category_by_slug('category-slug')->term_id ); ?> 
           		 	
           		 </p>
            </div>
        </div>    
    
		<?php
		if ( have_posts() ) :
		?>
		<div class="col-sm-12 tabs-grey">
			<!-- Nav tabs -->
			<ul role="tablist" class="nav nav-tabs">
				<?php 
				/* -------------------------------------------------------
				** -------------------------------------------------------
				** 			Dynamically Grabs Posts from Post Type
				**						UNUSED
				** -------------------------------------------------------
				**--------------------------------------------------------
				$c = 0;
				// Start the loop.
				while ( have_posts() ) : the_post();
					
					
					$tarpos = '#pos'.$c;
					$class = ($c==0) ? 'active' : '';
					?>
					<li role="presentation" class="<?php echo $class; ?>"><a href="<?php echo $tarpos;?>" role="tab" data-toggle="tab"><?php the_title(); ?></a></li>
					<?php
					// End of the loop.
					$c++;

				endwhile;
				*/
				?>
				<?php 
				/* -------------------------------------------------------
				** -------------------------------------------------------
				** 			Manually Grabs Posts from Post Type
				**						**********
				** -------------------------------------------------------
				**--------------------------------------------------------*/
				?>
				<li role="presentation" class="active">
					<a 
						href="#<?php echo $freelancing_for_geeks->post_name; ?>" 
						aria-controls="<?php echo $freelancing_for_geeks->post_name; ?>" 
						role="tab" 
						data-toggle="tab"><?php echo $freelancing_for_geeks->post_title; ?>
					</a>
				</li>

				<li role="presentation">
					<a 
						href="#<?php echo $job_stuff_for_geeks->post_name; ?>" 
						aria-controls="<?php echo $job_stuff_for_geeks->post_name; ?>" 
						role="tab" 
						data-toggle="tab"><?php echo $job_stuff_for_geeks->post_title; ?>
					</a>
				</li>							

				<li role="presentation" class=""><a href="<?php bloginfo('url'); ?>/current-classes" role="tab">See All Courses</a></li>
			</ul>
		<?php
		else:  
		?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; ?>
		
        
		<?php
		if ( have_posts() ) :
		?>
			<!-- Tab panes -->
			<div class="tab-content">
				<?php
				/* -------------------------------------------------------
				** -------------------------------------------------------
				** 			Dynamically Grabs Posts from Post Type
				**						UNUSED
				** -------------------------------------------------------
				**--------------------------------------------------------
				$j = 0;
				// Start the loop.
				while ( have_posts() ) : the_post();
					$tarpos = 'pos'.$j;
					$classd = ($j==0) ? 'active' : '';
				?>				
				<div id="<?php echo $tarpos; ?>" role="tabpanel" class="tab-pane row <?php echo $classd; ?>">
                	<h1 class="col-sm-12"><?php the_title(); ?></h1>
                    <div class="col-sm-6 pull-right"><?php twentysixteen_post_thumbnail(); ?></div>
					<?php the_content(); ?>
				</div>
				<?php
					// End of the loop.
					$j++;
				endwhile;
				*/

				/* -------------------------------------------------------
				** -------------------------------------------------------
				** 			Manually Grabs Posts from Post Type
				**						**********
				** -------------------------------------------------------
				**--------------------------------------------------------*/				
				?>
				<div id="<?php echo $freelancing_for_geeks->post_name; ?>" role="tabpanel" class="tab-pane row active">
                	<h1 class="col-sm-12"><?php echo $freelancing_for_geeks->post_title; ?></h1>
                    <div class="col-sm-6 pull-right"><?php echo get_the_post_thumbnail( $freelancing_for_geeks->ID); ?></div>
					<?php echo apply_filters( 'the_content', $freelancing_for_geeks->post_content ); ?>
				</div>
				<div id="<?php echo $job_stuff_for_geeks->post_name; ?>" role="tabpanel" class="tab-pane row">
                	<h1 class="col-sm-12"><?php echo $job_stuff_for_geekss->post_title; ?></h1>
                    <div class="col-sm-6 pull-right"><?php echo get_the_post_thumbnail( $job_stuff_for_geeks->ID); ?></div>
					<?php echo apply_filters( 'the_content', $job_stuff_for_geeks->post_content ); ?>
				</div>										
				<div id="all-courses">
					
				</div>
			</div>
		<?php endif; ?>
		</div>
		
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
</div>

<?php get_footer(); ?>