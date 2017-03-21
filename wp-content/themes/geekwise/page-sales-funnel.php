<?php 

	// you should not be here if you've not selected a class

    if( isset( $_GET['class_id'] ) && !empty($_GET['class_id'] ) ) {

        define('GEEKWISE_CLASS_ID', $_GET['class_id'] );

    } else {

        header("Location: " . get_bloginfo('url') . '/current-classes');

    }

    $course = geekwise_get_class( GEEKWISE_CLASS_ID );
    	if( !is_array( $course['course_data'] ) || empty( $course['course_data'] ) ) {
    		die("That class does not exist");
    	} else {
    		$course = $course['course_data'];
    	}

    $round = geekwise_get_round_as_of( 'today' );

?>
<?php /* Template Name: Sales Funnel */ ?>

<?php /*?><?php get_header('salesfunnel'); ?><?php */?>
<?php get_header(); ?>
<div class="container">
<div id="primary" class="content-area">


	<main id="main" class="site-main" role="main">

		<!-- tab code starts -->
		<div class="tabs-grey tabs-grey2 sales-funnel">


			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-justified">
			 	<li class="active"><a href="#enter-email" data-toggle="tab">1. Enter Email</a></li>
			 	<li><a href="#confirm-class" data-toggle="tab">2. Confirm Class</a></li>
			 	<li><a href="#payment" data-toggle="tab">3. Payment</a></li>
			 	<li><a href="#confirmation" disabled style="cursor:no-drop;">4. Confirmation</a></li>
			</ul>


			<!-- Tab panes -->
			<form action="<?php echo plugins_url('geekwise-gets-mission-control') . '/charge.php'; ?>" method="post" id="payment-form" role="form" data-toggle="validator">
			<div class="tab-content">
			
					<div id="enter-email" class="tab-pane active">
						<div class="col-md-8 col-md-offset-2">
							<h1 style="margin-bottom:0;">Student Information</h1>
							<h3>* Required Fields</h3>
							<h4 style="margin-bottom:2em;"">Registering for: <?php echo $course['class_name']; ?></h4>
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
    									<label for="student_name">Student Name *</label>
										<input 
											type="text" 
											placeholder="Jane Doe" 
											name="student_name" 
											id="student_name" 
											class="form-control" 
											required
										/>
										<div class="help-block with-errors"></div>
									</div><br />
								</div>
								<div class="col-sm-8">
									<div class="form-group">
    									<label for="student_email">Student Email *</label>
										<input 
											type="email" 
											placeholder="example@domain.com" 
											name="student_email" 
											id="student_email" 
											class="form-control" 
											required
										/>
										<div class="help-block with-errors"></div>
									</div><br />
								</div>								
								<div class="col-sm-8">
									<div class="form-group">
    									<label for="student_phone">Student Phone *</label>
										<input 
											type="tel" 
											placeholder="559-555-1234" 
											name="student_phone" 
											id="student_phone" 
											class="form-control"
											required 
										/>
										<div class="help-block with-errors"></div>
									</div><br />
								</div>									
								<div class="col-sm-8"><a onclick="event.preventDefault(); jQuery('a[href=\'#confirm-class\']').tab('show');" href="#" type="button" class="btn btn-primary btn-block" />Next </a></div>
							</div>
						</div>
					</div>


					<div id="confirm-class" class="tab-pane">
						<div class="col-sm-6">
							<h1><?php echo $course['class_name']; ?></h1>
							<p class="desc"><?php echo $course['class_description']; ?></p>
							<div class="section-duration">

							</div>
							<p><strong>Class Length:</strong> 6 weeks
								<br /><strong>Dates:</strong> 
								<?php 							
									$class_dates = geekwise_class_start_end_by_round_per_class( $round, $course );
									echo $class_dates['start'] . ' - ' . $class_dates['end'];
								?>
								<br /><strong>Day:</strong>
								
								<?php 								
									echo $class['class_day_1'];

									if( !empty( $course['class_day_2'] ) ){
										echo " and ";
										echo $course['class_day_2'];
									}
								?>

								<br /><strong>Time:</strong> 6:00 - 9:00 pm
							</p>
							<p class="available-seats"><strong><?php echo $available_seats = $course['max_enrollment'] - $course['students_enrolled']; ?> available seats left for this class!</strong></p>	
						</div>
						<div class="col-sm-5 col-sm-push-1">
							<div class="selected-class">
								<p>
									<strong>Class Selection:</strong> <?php echo $course['class_name']; ?>
									<br /><strong>Total Cost:</strong> $<?php echo $course['cost']; ?>
								</p>
								<a onclick="event.preventDefault(); jQuery('a[href=\'#payment\']').tab('show');" href="#" type="button" class="btn btn-primary btn-block">Enroll Into Course</a>
							</div>
							<img src="<?php bloginfo('url'); ?>/wp-content/uploads/2016/07/icon-cards.jpg" alt="icon-cards" width="600" height="84" class="alignnone size-full wp-image-593" />
						</div>
					</div>

				
				<div id="payment" class="tab-pane">

						<div class="col-md-8 col-md-offset-2">
							
							<h1 style="margin-bottom:.5em;">Registering for: <br/><?php echo $course['class_name']; ?></h1>
							<span class="payment-errors"></span>
										
							<div class="row">
	                            <div class="col-xs-12">
	                                <div class="form-group">
	                                    <label for="cardNumber">CARD NUMBER</label>
	                                    <div class="input-group">
	                                        <input 
	                                            type="tel"
	                                            class="form-control"
	                                            data-stripe="number"
	                                            placeholder="Valid Card Number"
	                                            autocomplete="cc-number"
	                                            required autofocus 
	                                        />
	                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
	                                    </div>
	                                </div>                            
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-xs-4 col-md-4">
	                                <div class="form-group">
	                                    <label for="cardExpiryMM"><span class="hidden-xs">EXPIRATION</span> MONTH</label>
	                                    <input 
	                                        type="tel" 
	                                        class="form-control" 
	                                        placeholder="MM"
	                                        data-stripe="exp_month"
	                                        size="2"
	                                        required 
	                                    />
	                                </div>
	                            </div>
	                            <div class="col-xs-4 col-md-4">
	                                <div class="form-group">
	                                    <label for="cardExpiryYY"><span class="hidden-xs"></span> YEAR</label>
	                                    <input 
	                                        type="tel" 
	                                        class="form-control" 
	                                        placeholder="YY"
	                                        data-stripe="exp_year"
	                                        size="2"
	                                        required 
	                                    />
	                                </div>
	                            </div>	                            
	                            <div class="col-xs-3 col-md-3 pull-right">
	                                <div class="form-group">
	                                    <label for="cardCVC">CV CODE</label>
	                                    <input 
	                                        type="tel" 
	                                        class="form-control"
	                                        data-stripe="cvc"
	                                        size="4"
	                                        placeholder="CVC"
	                                        autocomplete="cc-csc"
	                                        required
	                                    />
	                                </div>
	                            </div>
	                        </div>
	                        <!--
	                        <div class="row">
	                            <div class="col-xs-12">
	                                <div class="form-group">
	                                    <label for="couponCode">COUPON CODE</label>
	                                    <input 
	                                    	type="text" 
	                                    	class="form-control" 
	                                    	name="couponCode" 
	                                    	placeholder="Optional"
	                                    />
	                                </div>
	                            </div>                        
	                        </div>
	                        -->
	                        <div class="row">
	                            <div class="col-xs-12">
	                            	<input type="hidden" name="amount" value="<?php echo $course['cost'] * 100; ?>" />
	                            	<input type="hidden" name="class_id" value="<?php echo $course['class_id']; ?>" />
	                            	<input type="hidden" name="description" value="<?php echo $course['class_name']; ?>" />
	                                <input type="submit" class="subscribe btn btn-success btn-lg btn-block" value="Register for Class">
	                            </div>
	                        </div>
						  
	                      </div>
					</div>


				<div id="confirmation" class="tab-pane confirmation">
					<h1>You’re signed up! The future of the tech industry just got brighter.</h1>
					<p>For your records we have also sent you a confirmation email :-)</p>
					<p><a href="#">Click here to get back to the home page.</a></p>
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
