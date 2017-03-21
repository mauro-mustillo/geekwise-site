<?php

	
	ini_set( 'display_errors', 1 );

	
	require_once('geekwise-gets-mission-control.php');

	

    $link = mysql_connect(MISSION_CONTROL_DB_HOST, MISSION_CONTROL_DB_USER, MISSION_CONTROL_DB_PASSWORD);
    if (!$link) {
      die('Could not connect: ' . mysql_error());
    }
    $db = mysql_select_db( MISSION_CONTROL_DB_NAME ); 


   	

    /*------------------------------------------------------
     * Find students that have not been added to drip yet.
     * These people were probably added manually through 
     * through the dashboard.
     *----------------------------------------------------*/
    $qry_get_students = "SELECT * FROM `geekwise_students`
                            WHERE `class_id` 
                                IN (SELECT `id` FROM  `geekwise_classes` 
                                    WHERE  `geekwise_round` = " . GEEKWISE_ROUND_OF_CLASSES . ")
                                    AND `drip_subscriber_id` = ''
                                    AND `subscribed_to_drip` = 0";

    $res_get_students = mysql_query( $qry_get_students ) or die("Bad query: <br />" . mysql_error() . "<br />" . $qry_get_students );

    $num_get_students = mysql_num_rows( $res_get_students );

    if( !empty( $num_get_students ) ) {
       
        echo '<p>' . $num_get_students . ' to update: </p>';

	    /*------------------------------------------------------
	     * Create a Drip Subscriber for each student
	     *----------------------------------------------------*/
	    $drip = new Drip_Api( DRIP_API_TOKEN );

	    $new_students = array();
	    while( $student = mysql_fetch_object( $res_get_students ) ) {

	        preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $student->student_name, $name_results);
	        $first_name = $name_results[2];

	        $qry_get_class = "SELECT * FROM `geekwise_classes` WHERE `id` = " . $student->class_id . " LIMIT 1";
	        $res_get_class = mysql_query( $qry_get_class ) or die("Bad query: <br />" . mysql_error() . "<br />" . $qry_get_class );
	        $class = mysql_fetch_object( $res_get_class );


	        $new_student = array(

	            'email'         =>  $student->student_email,
	            'time_zone'     =>  'America/Los_Angeles',
	            'custom_fields' =>  array(

	                'first_name'=>  $first_name,
	                'class'     =>  $class->class_name

	            
	            )

	        );


	        $params = array( 
	            'account_id'        =>      DRIP_ACCOUNT_ID,
	            'subscribers'       =>      $new_student
	        );

	        $drip_subscriber = $drip->create_or_update_subscriber( $params );


	        
		    /*------------------------------------------------------
		     * Update student record with drip id.
		     *----------------------------------------------------*/
	        $qry_update_student = "UPDATE  `db50925_geekwiseacademy`.`geekwise_students` SET  `drip_subscriber_id` =  '" . $drip_subscriber['id'] . "' WHERE  `geekwise_students`.`id` =" . $student->id . ";";
	        $res_update_student = mysql_query($qry_update_student ) or die( 'Query failed: <br />' . $qry_update_student . '<br />' . mysql_error() );

	        if( $res_update_student ) {
	          echo '<br /><br />Student: ' . $student->id . ' updated to:' . $drip_subscriber['id'];  
	        }

	    } // end while

	}

	




   	


    /*------------------------------------------------------
     * Are we within 4 days of the start of classes?
     *----------------------------------------------------*/
    $qry_get_round = "SELECT * FROM `geekwise_round` 
    						WHERE NOW() <= DATE_ADD(`start_date`, INTERVAL 3 DAY) 
    								AND  NOW() >= DATE_SUB(`start_date`, INTERVAL 4 DAY)
    									LIMIT 1";
   	$res_get_round = mysql_query( $qry_get_round ) or die("Bad query: <br />" . mysql_error() . "<br />" . $qry_get_round );

   	$current_round = mysql_fetch_object( $res_get_round );   

   	if( empty( $current_round) ) {

   		die( 'We are not close enough to a new round of classes to subscribe students to the drip campaign.');

   	}	




    /*------------------------------------------------------
     * We are within 4 days of the start of a round of classes.
     * Time to start sending drip stuff
     * Get all the students in all the classes taught in this round
     *----------------------------------------------------*/
	$qry_get_students = "SELECT * FROM `geekwise_students`
							WHERE `class_id` 
								IN (SELECT `id` FROM  `geekwise_classes` 
									WHERE  `geekwise_round` = " . $current_round->number . ")";
									

	$res_get_students = mysql_query( $qry_get_students ) or die("Bad query: <br />" . mysql_error() . "<br />" . $qry_get_students );

	$num_get_students = mysql_num_rows( $res_get_students );

	if( empty( $num_get_students ) ) {
		die('There aren\'t any students to subscribe to the campaign. Maybe they have all already been subscribed?');
	}


	$drip = new Drip_Api( DRIP_API_TOKEN );

	// set up the defaults for subscribing to a campaign
	$params = array( 
		'account_id'		=>		DRIP_ACCOUNT_ID,
		'campaign_id'		=>		DRIP_CAMPAIGN_ID,
		'email'				=>		'irma.olguin.jr@gmail.com',
		'double_optin'		=>		false
	);


    /*------------------------------------------------------
     * Subscribe them to our drip campaign.
     * Make sure repeat students get on the repeat student
     * email campaign.
     * Update their student record to show that they 
     * have been subscribed to a campaign.
     *----------------------------------------------------*/
	while( $student = mysql_fetch_object( $res_get_students ) ) {


		
		// designated rounds to skip
		if( $current_round->number == GEEKWISE_SUMMER_CAMP_ROUND ) {
			continue;
		}

		// repeat student, send them to the 
		// repeat student campaign
		// otherwise, subscribe to first-timers campaign
		$clean_student_email = mysql_real_escape_string( $student->student_email );

		$repeat_student_qry = "SELECT * FROM `db50925_geekwiseacademy`.`geekwise_students`
									WHERE `geekwise_students`.`student_email` = '" . $clean_student_email . "'";
		$repeat_student_res = mysql_query( $repeat_student_qry ) or die("Bad query: <br />" . mysql_error() . "<br />" . $repeat_student_qry );
		$num_student_classes = mysql_num_rows( $repeat_student_res );


		if( $num_student_classes >= 2 ) {
			$params['campaign_id'] = DRIP_REPEAT_CAMPAIGN_ID;
		} else {
			$params['campaign_id'] = DRIP_CAMPAIGN_ID;
		}

		$params['email'] = $student->student_email;

		$is_subscribed = $drip->subscribe_subscriber( $params );
		if( !empty( $is_subscribed ) ) {

			$qry_update_student = "UPDATE  `db50925_geekwiseacademy`.`geekwise_students` 
										SET  `subscribed_to_drip` =  '1' 
											WHERE  `geekwise_students`.`id` =" . $student->id . ";";

			$res_update_student = mysql_query( $qry_update_student ) or die("Bad query: <br />" . mysql_error() . "<br />" . $qry_update_student );

		}
					

	}