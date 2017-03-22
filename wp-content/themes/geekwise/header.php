<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<!--<meta charset="<?php //bloginfo( 'charset' ); ?>">-->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">    
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/geekwise-favicon.png">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->    
<link href="<?php bloginfo("template_url"); ?>/css/bootstrap.min.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,300italic,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href="<?php bloginfo("template_url"); ?>/css/custom.css" rel="stylesheet">


</head>

<body <?php body_class(); ?>>



<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

<div class="site-header-wrapper">

<header id="masthead" class="site-header container" role="banner">
    <div class="site-header-main row">
        <div class="site-branding col-sm-12 col-xs-12">

        	<div class="row">
                <div class="col-sm-6 col-xs-4 col-md-2 logo">
                    <?php twentysixteen_the_custom_logo(); ?>
                </div>
                 <div class="col-sm-8 col-xs-8 col-md-10 ">
                
                <div class="link-signup-for-class">
                   <?php dynamic_sidebar('header-top-right'); ?>
                </div> 
                  <div id="main-nav" >
          <?php dynamic_sidebar( 'main-menu' ); ?>
</div>           
            </div>
            
            <?php if ( is_front_page() && is_home() ) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php endif;

            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p class="site-description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div><!-- .site-branding -->
		
      
    </div><!-- .site-header-main -->

    <?php if ( get_header_image() ) : ?>
        <?php
            /**
             * Filter the default twentysixteen custom header sizes attribute.
             *
             * @since Twenty Sixteen 1.0
             *
             * @param string $custom_header_sizes sizes attribute
             * for Custom Header. Default '(max-width: 709px) 85vw,
             * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
             */
            $custom_header_sizes = apply_filters( 'twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px' );
        ?>
        <div class="header-image">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
            </a>
        </div><!-- .header-image -->
    <?php endif; // End header image check. ?>
    
    
	<?php /*?><?php if ( is_front_page() ) { ?>
    	<?php dynamic_sidebar('home-hero-section'); ?>
    <?php } ?><?php */?>
    
	
    
     
</header><!-- .site-header -->





</div>

		<div id="content" class="site-content">
