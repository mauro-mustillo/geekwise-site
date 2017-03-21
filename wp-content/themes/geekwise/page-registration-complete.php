<?php 

	// you should not be here if you've not selected a class

    if( isset( $_GET['class_id'] ) && !empty($_GET['class_id'] ) ) {

        define('GEEKWISE_CLASS_ID', $_GET['class_id'] );

    } else {

        header("Location: " . get_bloginfo('url') . '/current-classes');

    }

?>
<?php /* Template Name: Sales Funnel Complete */ ?>

<?php get_header('salesfunnel'); ?>

<div class="container">
<div id="primary" class="content-area">


	<main id="main" class="site-main" role="main">

		<!-- tab code starts -->
		<div class="tabs-grey tabs-grey2 sales-funnel">


			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-justified">
			 	<li><a href="#enter-email" disabled style="cursor:no-drop;">1. Enter Email</a></li>
			 	<li><a href="#confirm-class" disabled style="cursor:no-drop;">2. Confirm Class</a></li>
			 	<li><a href="#payment" disabled style="cursor:no-drop;">3. Payment</a></li>
			 	<li class="active"><a href="#confirmation" data-toggle="tab">4. Confirmation</a></li>
			</ul>


			<!-- Tab panes -->
			<form action="<?php echo plugins_url('geekwise-gets-mission-control') . '/charge.php'; ?>" method="post" id="payment-form" role="form" data-toggle="validator">
			<div class="tab-content">
			
					<div id="enter-email" class="tab-pane">
						
					</div>


					<div id="confirm-class" class="tab-pane">
						
					</div>

				
					<div id="payment" class="tab-pane">

					</div>


				<div id="confirmation" class="tab-pane active confirmation  ">
					<h1>You’re signed up! The future of the tech industry just got brighter.</h1>
					<p>For your records we have also sent you a confirmation email :-)</p>
					<p><a href="<?php bloginfo('url'); ?>">Click here to get back to the home page.</a></p>
				</div>


			</div>


			</form>
		</div>	
        
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>

</div>



<?php get_footer('sales'); ?>
