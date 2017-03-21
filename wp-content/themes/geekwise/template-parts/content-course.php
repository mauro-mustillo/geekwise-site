<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->

	<?php /*?><?php custom_breadcrumbs(); ?><?php */?>
	
	<?php twentysixteen_excerpt(); ?>
	

    
   <div class="col-sm-6">
    		<?php twentysixteen_post_thumbnail(); ?>
  </div>
   
   <div class="col-sm-6">
<div class="row skill-level">
<div class="col-sm-5"><img  src="<?php the_field('skills'); ?>" alt="Course Skill Level"  /></div>
<div class="col-sm-7">Skill Level:<br/>
<?php the_field('skill_level'); ?></div>
</div>
<div class="row class-details">
<ul>
 	<li>Course Cost<strong><?php the_field('course_cost'); ?></strong></li>
 	<li>Length <strong><?php the_field('course_length'); ?></strong></li>
</ul>
</div>
</div>

<?php /*?>	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><?php */?>    

	<div class="entry-content"><div id="course-description">
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

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
<?php if( get_field('what_you_will_learn_left') ): ?>
	<div class="what-you-learn">
<h2>What you will learn:</h2>
<div class="col-sm-6">
<?php the_field('what_you_will_learn_left'); ?>
</div>
<div class="col-sm-6">
<?php the_field('what_you_will_learn_right'); ?>
</div>
</div>	
<?php endif; ?>	
	
<?php if( get_field('week_by_week') ): ?>			
<div class="program">
<h2>Program</h2>
<div class="col-sm-6">
	<?php the_field('week_by_week'); ?>				
</div>
<div class="col-sm-6">
	<?php the_field('week_by_week_right'); ?>				
</div>								
</div>	
<?php endif; ?>			
	</div></div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php //twentysixteen_entry_meta(); ?>
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