<?php /* Template Name: All Courses Template */ ?>

<?php get_header(); ?>

<div class="container">
<div id="primary" class="content-area">


	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );



			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php 

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

				<div class="row current-courses-header hidden-xs visible-sm visible-md visible-lg">
					<div class="col-sm-4">Topic</div>
					<div class="col-sm-2">Duration</div>
					<div class="col-sm-2">Day/Time</div>
					<div class="col-sm-2">Fee</div>
					<div class="col-sm-2">Sign-up</div>
				</div>				
				<?php 

				foreach( $classes as $class ) { 


					$is_sold_out = ( $class['students_enrolled'] >= $class['max_enrollment'] ? true : false );


				?>

				<div class="row current-courses-row clearfix <?php if ( $is_sold_out === true ) { echo 'sold-out'; } ?>">
					<div class="col-sm-4">
						<div class="course-title-sm visible-xs hidden-sm">Topic</div>
						<p><strong><?php echo $class['class_name']; ?></strong>
						<br /><?php echo $class['class_description']; ?></p>
					</div>
					<div class="col-sm-2">
						<div class="course-title-sm visible-xs hidden-sm">Duration</div>
						<strong>6 Weeks</strong>
						<br />
						<?php 

							$class_dates = geekwise_class_start_end_by_round_per_class( $round, $class );
							echo $class_dates['start'] . ' through ' . $class_dates['end'];


						?>
					</div>
					<div class="col-sm-2">
						<div class="course-title-sm visible-xs hidden-sm">Day/Time</div>
						<strong>
							<?php 
								echo $class['class_day_1'];
								if( !empty( $class['class_day_2'] ) ){
									echo " & ";
									echo $class['class_day_2'];
								}	
							?>
						</strong>
						<br />6:00p - 9:00p
					</div>
					<div class="col-sm-2">
						<div class="course-title-sm visible-xs hidden-sm">Fee</div>
						<strong>$<?php echo $class['cost']; ?></strong>
						<br />36 hrs. in-person instruction
					</div>
					<div class="col-sm-2">

						<?php if ( $is_sold_out === true ) { ?>
						
							<div class="course-title-sm visible-xs hidden-sm">Sign-up</div>
							<button href="#"  type="button" class="btn btn-enroll btn-block sold-out-btn" disabled>SOLD OUT</button>

						<?php } else { ?>
							
							<div class="course-title-sm visible-xs hidden-sm">Sign-up</div>
							<a href="<?php bloginfo('url'); ?>/sales-funnel/?class_id=<?php echo $class['class_id']; ?>"  type="button" class="btn btn-enroll btn-block">Enroll</a>

						<?php } ?>
					</div>
				</div>
				
				<?php 
				}

			} else {
				echo '<h1>We are having trouble retreiving the list of current classes. Please try again shortly.</h1><h2>If the problem persists, please call Terry Solis at 559-472-8786</h2>';
			}
		
		} else {
		
			echo '<p>The course listing depends on the <b>Geekwise Gets Misson Control</b> plugin. Make sure it is installed and activated!';
		
		}

	?>
<div id="sold-out-items"></div> 






<h2 class="limited-seat">SEATING IS LIMITED, SIGN-UP TODAY!</h2>









	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>


<script>
jQuery(document).ready(function($){

$('.sold-out').prependTo('#sold-out-items');

});
</script>


<?php get_footer(); ?>
