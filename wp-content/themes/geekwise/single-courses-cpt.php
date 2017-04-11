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


<?php
$courseId = '58ebe32a70a4020678ccb9b4';
$course = getCourseById($courseId);

if ($course === false) {
	//Invalid Course. Do something.
} else {
	//Valid course. Show it!
}
$courseName = $course->name;
$courseCost = $course->cost;
$courseStart = $course->start_date;
$courseEnd = $course->end_date;
$maxEnrollment = $course->max_enrollment;
$courseDays = $course->days;	//Array
	?>
	

<div class="container">
<h1 class="entry-title"><?php single_post_title(); ?></h1>	
<div id="primary" class="content-area post-detail col-sm-10 col-sm-push-1">
	<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
		
	

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'course' );
			
		
		

 

		/* -------------------------------------------------
		** -------------------------------------------------
		** 		Display Courses from Mission Control
		** -------------------------------------------------
		** -----------------------------------------------*/

		if( function_exists( 'geekwise_get_classes' ) ) {

			$round = geekwise_get_round_as_of( 'today' );
			$classes = geekwise_get_classes( $round );


			if (is_array( $classes) ) {


				$classes = $classes['courses'];

				?>

<div id="enroll-buttons">						
				<?php 

				foreach( $classes as $class ) { 


					$is_sold_out = ( $class['students_enrolled'] >= $class['max_enrollment'] ? true : false );


				?>

		
				
					

					
				
				
<div class="enroll-to-course">
						<?php if ( $is_sold_out === true ) { ?>
						
					
							<?php /*?><button href="#"  type="button" class="btn btn-enroll btn-block sold-out-btn" disabled>SOLD OUT - <?php echo $class['class_name']; ?></button><?php */?>

						<?php } else { ?>
							
							
							<a href="<?php bloginfo('url'); ?>/sales-funnel/?class_id=<?php echo $class['class_id']; ?>"   ><strong>Enroll Now!</strong> <?php echo $class['class_name']; ?> <em>Click Here</em> </a>

						<?php } ?>
					
	</div>			
				
				<?php 
				}

			} else {
				echo '<h1>We are having trouble retreiving the list of current classes. Please try again shortly.</h1><h2>If the problem persists, please call Terry Solis at 559-472-8786</h2>';
			}
		
		} else {
		
			echo '<p>The course listing depends on the <b>Geekwise Gets Misson Control</b> plugin. Make sure it is installed and activated!';
		
		}

	
		
		
		
		
		
			echo '<div class="social-media clearfix">';
			echo '<p class="twitter radius5">Twitter<span>20</span></p>';
			echo '<p class="facebook radius5">Facebook<span>1</span></p>';			
			echo '</div>';			
		echo '</div>';	
		
			if(get_field('requirements'))
{
	echo '<div id="course-requirements"><h2><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Requirements</h2>';
	echo '<p>' . get_field('requirements') . '</p>';
		echo '</div>';
}
		
		 	echo '<div id="related-courses"><h4>Browse More Courses</h4>';
			dynamic_sidebar( 'related-courses' );
			echo '</div>';	
		
			


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




</div><!-- .content-area -->

<?php //get_sidebar(); ?>
</div>
</div>

<script>
jQuery(document).ready(function($){
$( ".courses-cpt-websites-for-beginners .enroll-to-course:contains('Websites for Beginners')" ).css( "display", "inline-block" );
$( ".courses-cpt-javascript-for-beginners .enroll-to-course:contains('Javascript for Beginners')" ).css( "display", "inline-block" );
$( ".courses-cpt-mobile-first-websites .enroll-to-course:contains('Mobile-Friendly')" ).css( "display", "inline-block" );
	$( ".courses-cpt-mobile-first-websites .enroll-to-course:contains('Mobile Friendly')" ).css( "display", "inline-block" );
$( ".courses-cpt-intro-to-angularjs .enroll-to-course:contains('Intro to AngularJS')" ).css( "display", "inline-block" );
});

</script>
<script>
jQuery(document).ready(function($){

$(function () {
    $("#enroll-buttons a").each(function () {
        $(this).html($(this).html().split(" - ").join("</span><br/><span>"));
    });
});

});
</script>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}
</script>

<?php get_footer(); ?>
