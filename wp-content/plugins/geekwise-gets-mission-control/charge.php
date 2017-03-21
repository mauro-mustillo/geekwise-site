<?php ini_set('display_errors', 1); ?>
<?php

    $has_errors = false;

    require_once(dirname(__FILE__) . '/config.php');
    

    if( empty($_POST['stripeToken']) ) {
        die('Not allowed, dude.');
    }
    
    $token  = $_POST['stripeToken'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $name = filter_var($_POST['student_name'], FILTER_SANITIZE_STRING);
    $phone = preg_replace("/[^\d]+/","", @$_POST['student_phone']);
    $class_id = $_POST['class_id'];

    // separate the name
    preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $name, $name_results);
    if( !empty( $name_results[2]) ) {
        $first_name = $name_results[2];
    } elseif ( !empty( $name_results[1]) ) {
        $first_name = $name_results[1]; 
    } elseif ( !empty( $name_results[0]) ) {
        $first_name = $name_results[0];
    } else {
        $first_name = "Friend";
    } 


    if( empty($_POST['student_phone'])) {
        die('Please go back and enter your phone number. Your card has not been charged.');
    } else {
        $phone = $_POST['student_phone'];
    }


    if(!filter_var($_POST['student_email'], FILTER_VALIDATE_EMAIL)) {
        die('Please go back and use a valid email address. Your card has not been charged.');
    } else {
        $email = $_POST['student_email'];
    }




    /*------------------------------------------------------
     * Create a Stripe Customer 
     *----------------------------------------------------*/

    $customer = Stripe_Customer::create(array(
      'email' => $email,
      'description' => $name . ', ' . $phone . ', ' . $description,
      'card'  => $token
    ));



    $charge = Stripe_Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $amount,
      'currency' => 'usd'
    ));



    if( empty( $customer ) || empty( $charge ) ) {

        $subject = 'Customer not created in Stripe';
        $body  = '<pre>POST, customer, charge';
        $body .= var_export( $_POST, true );
        $body .= var_export( $customer, true );
        $body .= var_export( $charge, true );
        $body .= '</pre>';


        Mail_Postmark::compose()
        ->addBcc($mail_bcc_from_email, $mail_bcc_from_name)
        ->subject( $subject )
        ->messageHtml( $body )
        ->send();

        die('The charge was not successful. You can contact info@geekwiseacademy.com if you have any questions.'); 
    }



    /*------------------------------------------------------
     * Create a Drip Subscriber
     *----------------------------------------------------*/
    $new_student = array(

        'email'         =>  $email,
        'time_zone'     =>  'America/Los_Angeles',
        'custom_fields' =>  array(

            'first_name'=>  $first_name,
            'class'     =>  $description

        
        )

    );


    $drip = new Drip_Api( DRIP_API_TOKEN );

    $params = array( 
        'account_id'        =>      DRIP_ACCOUNT_ID,
        'subscribers'       =>      $new_student
    );

    $drip_subscriber = $drip->create_or_update_subscriber( $params );









    /*------------------------------------------------------
     * Send Email to Student 
     *----------------------------------------------------*/
    $subject = 'Registration for: ' . $name . ' (' . $description . ')';
    
  

        $body = '
            <p>Hi ' . $first_name . ',</p>
         
            <p>This e-mail confirms that you have just signed up for the leanest and fastest technological training on earth (Ok, so we can’t verify that, but we’re pretty sure you’re going to agree).</p>
             
            <p>Your course registration is now complete. During the week prior to the start of your selected course you will receive an informational e-mail detailing how the course works, what you will need, and providing additional important information. Until then, feel free to contact us with any questions, concerns, or general awesomeness.</p>

            <p>We look forward to seeing you soon at Geekwise Academy!</p>
             
            <p>Sincerely,<br />
            Terry Solis<br />
            tsolis@geekwiseacademy.com<br />
            <a href="http://www.GeekwiseAcademy.com/">www.GeekwiseAcademy.com</a><br />
            (559) 472-8786<br /></p>

            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <p>P.S. As a Geekwise student, we would like to offer you one free month at The Hashtag. It\'s a great place to study and open 24 hours a day. Here\'s how to get your free month:</p>
                <ol>
                    <li>Go to <a href="http://hashtagfresno.com">hashtagfresno.com</a></li>
                    <li>Click "Become A Member"</li>
                    <li>Choose the Geekwise Offer from the dropdown menu/li>
                    <li>Enter #gkw# in the Discount Code field to activate your free month!</li>
                </ol>

                <p>After your free month, the regular rate of $39 a month will be billed automatically for as long as you\'re a member. You can cancel at anytime. We hope you stay, though, because The Hashtag is the coolest place to work in Fresno.</p>
        ';







        Mail_Postmark::compose()
        ->addTo( $email, $name)
        ->addBcc($mail_bcc_from_email, $mail_bcc_from_name)
        ->subject( $subject )
        ->messageHtml( $body )
        ->send(); 



    /*------------------------------------------------------
     * Send Email to Geekwise Staff
     *----------------------------------------------------*/
    $subject = 'New ' . $description . ' Registration (' . $customer->id . ')';
    $body = '
    Name:  ' . $name  . '<br />
    Email: ' . $email . '<br />
    Phone: ' . $phone . '<br />
    Amount: $' . number_format(($amount/100),2) . '<br />
    Class: ' . $description . '<br />
    Drip: ' . $drip_subscriber['id'] . '<br />
    Token: ' . $token; 
    
    Mail_Postmark::compose()
    ->addTo( $mail_bcc_from_email, $mail_bcc_from_name )
    ->addBcc("tsolis@bitwiseindustries.com", "I. Terry Solis")
    ->addBcc("bmily@geekwiseacademy.com", "Bethany E. Mily")
    ->addBcc("ggoforth@shift3tech.com", "Greg D. Goforth")
    ->subject( $subject )
    ->messageHtml( $body )
    ->send(); 


    /*--------------------------------
    ** INSERT TO DB
    ---------------------------------*/
    $today = date('Y-m-d h:i:s');

    $link = mysql_connect(MISSION_CONTROL_DB_HOST, MISSION_CONTROL_DB_USER, MISSION_CONTROL_DB_PASSWORD);
    if (!$link) {
      die('Could not connect: ' . mysql_error());
    }
    $db = mysql_select_db( MISSION_CONTROL_DB_NAME );    
    $query = "INSERT INTO `db50925_geekwiseacademy`.`geekwise_students` 
                (`id`, `class_id`, `student_name`, `student_email`, `student_phone`, `payment_method`, `payment_date`, `drip_subscriber_id` )
                VALUES (
                    NULL, 
                    '" . $class_id . "', 
                    '" . $name . "', 
                    '" . $email . "', 
                    '" . $phone . "',
                    'stripe', 
                    '" . $today . "',
                    '" . $drip_subscriber['id'] . "'
                );";        
    $result = mysql_query( $query ) or die( 'Query failed: <br />' . $query . '<br />' . mysql_error() );
    
    

    /*--------------------------------
    ** ADD TO MAILING LIST (ID: 141901)
    ---------------------------------*/
    $mailchimp = new Mailchimp( MAILCHIMP_APIKEY );
        $mailchimp_list_id = '5993673aef'; // BITWISE OPT-IN
        $mailchimp_email = array(
            'email' => $email
        );

        
        // assume everything before the first space is 
        // the first name
        $names = explode(' ', $name);
            $fname = '';
            $lname = '';

                $i = count($names);

                $fname = $names[0];
                for( $x = 1; $x < $i; $x++ ) {

                    $lname .= $names[$x] . ' ';

                }

                $lname = trim( $lname );

        $mailchimp_merge_vars = array("FNAME"=>$fname, "LNAME"=>$lname);
        
        

        $mailchimp_segment_name = $description;
    try {
        
        
        // get lists
        // var_dump( $mailchimp->lists->getList() );

        // get static segments & find out if ours already exists
        $segments = $mailchimp->lists->staticSegments( $mailchimp_list_id );
        $segment_exists = false;
        if( is_array($segments) ){

            foreach( $segments as $segment ) {

                if( true === $segment_exists )
                    continue;

                if ( false !== array_search( $mailchimp_segment_name, $segment ) ) {
                    $segment_exists = true;
                    $mailchimp_segment_id = $segment['id'];
                } 
            
            }

        }

        // create the segment, if necessary
        if( false === $segment_exists ) {

            $mailchimp_segment = $mailchimp->lists->staticSegmentAdd( $mailchimp_list_id, $mailchimp_segment_name );
            $mailchimp_segment_id = $mailchimp_segment['id'];
        } 
            
        // subscribe
        $mailchimp_user= $mailchimp->lists->subscribe( $mailchimp_list_id, $mailchimp_email, $mailchimp_merge_vars, $email_type='html', $double_optin=false, $update_existing=true, $replace_interests=true, $send_welcome=false );
        
        // update with first/last name
        //$mailchimp_updated = $mailchimp->lists->listUpdateMember($mailchimp_list_id, $email, $mailchimp_merge_vars, 'html', false);        
        //var_dump( $mailchimp_updated);

        // add to segment
        $mailchimp_result = $mailchimp->lists->staticSegmentMembersAdd( $mailchimp_list_id, $mailchimp_segment_id, array( 0 => $mailchimp_user ) );

        

        
        
    } catch (Mailchimp_Error $e) {
        
        //echo $e;
    
    }    


    //if( $has_errors === false ) {
        header("Location: http://v3.geekwiseacademy.com/registration-complete/?class_id=" . $class_id);
    //}


?>