<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

<?php /*?>	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><?php */?>
    <!-- .entry-header -->
	
    <div class="col-sm-12">
    
    <div class="col-sm-4"><?php twentysixteen_post_thumbnail(); ?></div>

	<div class="entry-content- col-sm-8">
    	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php
            echo '<p class="info"><strong>Class: </strong>'. get_post_meta($post->ID, "class", true).'&nbsp;&nbsp;|&nbsp;&nbsp;';
			echo '<strong>Instructor: </strong>'. get_post_meta($post->ID, "instructor", true).'</p>';            
		?>
		<?php
		the_content();
		
		//echo '<strong>Codepen:</strong>'. get_post_meta($post->ID, "codepen", true).'</p>';
		
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div>
    
    <div class="col-sm-12 codepen-wrapper">
    	<?php echo get_post_meta($post->ID, "codepen", true).'</p>'; ?>
    </div>
    
    <!-- .entry-content -->
    
    </div>

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
				get_the_title()
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

</article><!-- #post-## -->
