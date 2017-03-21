<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <div class="row">
    
    <div class="col-sm-6 instructor-pic">
        <?php twentysixteen_post_thumbnail(); ?>
    </div>

	<div class="col-sm-6  instructor-details">
    
       <?php /*?> <header class="instructor-header">
            <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                <span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
            <?php endif; ?>
    <?php */?>
           
            <?php /*?><?php echo '<h2>'.get_post_meta($post->ID, "designation", true).', '.get_post_meta($post->ID, "company_name", true).'</h2>'; ?><?php */?>
       <!-- </header>--><!-- .entry-header -->
    
        <?php twentysixteen_excerpt(); ?>   
         
		<?php			
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
		
		<?php /*?><span>Kung-fu:</span> <?php echo '<p>'.get_post_meta($post->ID, "kung_fu", true).'</p>'; ?><?php */?>
		<?php /*?><span>Years coding:</span> <?php echo '<p>'.get_post_meta($post->ID, "years_coding", true).'</p>'; ?><?php */?>
        <p><strong>Work experience:</strong> <?php echo get_post_meta($post->ID, "work_experience", true); ?></p>
		<p><strong>Favorite tools:</strong> <?php echo get_post_meta($post->ID, "favorite_tools", true); ?></p>
		<p><strong>Geeky fact:</strong> <?php echo get_post_meta($post->ID, "geeky_fact", true); ?></p>
		<?php if(get_post_meta($post->ID, "students_think", true)) { ?>
        	<div class="quote">
        		<h3>What Students Think of <?php single_post_title(); ?></h3>
				<blockquote class="radius5">
					<?php echo get_post_meta($post->ID, "students_think", true) ?>
                    <cite>~ Student Stuff</cite>
                </blockquote>
            </div>
        <?php } ?>
	</div><!-- .instructor-details -->

	</div>

	<footer class="entry-footer">
		<?php twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
  <section >
          

            	<div id="more-fellows"><h3>More Fellows</h3>
				<?php echo do_shortcode('[ess_grid alias="browse-fellows"]'); ?></div>
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
        
        </section>