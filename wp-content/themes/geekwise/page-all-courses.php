<?php /* Template Name: All Courses Template */ ?>

<?php
$showCourse = false;
if (!empty($_GET['cid'])) {
	$showCourse = true;
} ?>

<?php get_header(); ?>

<div class="container">
<div id="primary" class="content-area">
	<?php 
	if ($showCourse) {
		$course = getCourseById($_GET['cid']);
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
		
		$startDate = new DateTime($class->start_date);
		$endDate = new DateTime($class->end_date);

		$unixStart = strtotime($class->start_date);
		$unixEnd = strtotime($class->end_date);

		$weeksInterval = $startDate->diff($endDate);
		$weeksBetween = (int) (($weeksInterval->days) / 7);
		?>
		<div>
			<?php echo $courseName;?>
		</div>
		<?php
	} else { ?>
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
		$classes = getCourses();

		if (is_array( $classes) ) {
			$classes = $classes[0]; ?>
			<div class="row current-courses-header hidden-xs visible-sm visible-md visible-lg">
				<div class="col-sm-4">Topic</div>
				<div class="col-sm-2">Duration</div>
				<div class="col-sm-2">Day/Time</div>
				<div class="col-sm-2">Fee</div>
				<div class="col-sm-2">Sign-up</div>
			</div>				
			<?php 

			foreach( $classes as $class ) { 
				$class = (array) $class;

				$startDate = new DateTime($class['start_date']);
				$endDate = new DateTime($class['end_date']);

				$unixStart = strtotime($class['start_date']);
				$unixEnd = strtotime($class['end_date']);

				$weeksInterval = $startDate->diff($endDate);
				$weeksBetween = (int) (($weeksInterval->days) / 7);

				$is_sold_out = ( $class['students_enrolled'] >= $class['max_enrollment'] ? true : false );
			?>

			<div class="row current-courses-row clearfix <?php if ( $is_sold_out === true ) { echo 'sold-out'; } ?>">
				<div class="col-sm-4">
					<div class="course-title-sm visible-xs hidden-sm">Topic</div>
					<h3><a href="?cid=<?php echo $class['_id'];?>"><?php echo $class['name']; ?></a></h3>
					<p><?php echo $class['description']; ?></p>
				</div>
				<div class="col-sm-2">
					<div class="course-title-sm visible-xs hidden-sm">Duration</div>
					<strong><?php echo $weeksBetween;?> Weeks</strong>
					<br />
					<?php 
						echo date('m/d/Y', $unixStart) . ' through ' . date('m/d/Y', $unixEnd);
					?>
				</div>
				<div class="col-sm-2">
					<div class="course-title-sm visible-xs hidden-sm">Day/Time</div>
					<strong>
						<?php 
							echo implode(', ',$class['days']);
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
			?>
			<div id="sold-out-items"></div> 
			<?php 
		} else {
			echo '<h1>We are having trouble retreiving the list of current classes. Please try again shortly.</h1><h2>If the problem persists, please call Terry Solis at 559-472-8786</h2>';
		}
	} ?>
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
