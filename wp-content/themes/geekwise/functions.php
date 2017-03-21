<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'social'  => __( 'Social Links Menu', 'twentysixteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Header Top Right', 'twentysixteen' ),
		'id'            => 'header-top-right',
		'description'   => __( 'Appears at the right of header logo', 'twentysixteen' ),
		'before_widget' => '<aside id="%1$s" class="col-sm-4">',
		'after_widget'  => '</aside>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Hero Section', 'twentysixteen' ),
		'id'            => 'home-hero-section',
		'description'   => __( 'Appears at the right of header logo', 'twentysixteen' ),
		'before_widget' => '<article id="%1$s" class="home-hero-section col-md-10 col-md-offset-1">',
		'after_widget'  => '</article>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );		
	register_sidebar( array(
		'name'          => __( 'Footer Contact Info', 'twentysixteen' ),
		'id'            => 'contact-info',
		'description'   => __( 'Appears at the footer left column', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="col-sm-6 col-md-4 block-footer block-contact">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Newsletter', 'twentysixteen' ),
		'id'            => 'newsletter',
		'description'   => __( 'Appears at the footer middle column', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="col-sm-6 col-md-4 block-footer">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Recent News', 'twentysixteen' ),
		'id'            => 'recent-news',
		'description'   => __( 'Appears at the footer right column', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="col-sm-12 col-md-4 block-footer block-recentnews">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Copyright', 'twentysixteen' ),
		'id'            => 'footer-copyright',
		'description'   => __( 'Appears at the footer bottom', 'twentysixteen' ),
		'before_widget' => '<div id="%1$s" class="footer-copyright">',
		'after_widget'  => '</div>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );
	register_sidebar( array(
		'name'          => __( 'Developer Fellow', 'twentysixteen' ),
		'id'            => 'developer-fellow',
		'description'   => __( 'Appears above developer fellow imagegrid in mentor page', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Geekwise Instructors', 'twentysixteen' ),
		'id'            => 'geekwise-instructors',
		'description'   => __( 'Appears above Geekwise Instructors imagegrid in mentor page', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'More Reading', 'twentysixteen' ),
		'id'            => 'more-reading',
		'description'   => __( 'Appears at the blog detail bottom', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="col-sm-12 block-more-reading">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Join Tribe', 'twentysixteen' ),
		'id'            => 'join-tribe',
		'description'   => __( 'Appears at the blog detail bottom', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="col-sm-12 block-join-tribe">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Related Courses', 'twentysixteen' ),
		'id'            => 'related-courses',
		'description'   => __( 'List of Courses', 'twentysixteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );	
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Sixteen.
 *
 * Create your own twentysixteen_fonts_url() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentysixteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}

	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );

/* code added to add custom fields in custom post types - starts */
add_action("admin_init", "admin_init");
 
function admin_init(){
  add_meta_box("success_stories_meta", "Other Details", "success_stories_meta", "success-stories-cpt", "normal", "low");
  add_meta_box("showcase_meta", "Other Details", "showcase_meta", "showcase-cpt", "normal", "low");
  add_meta_box("mentors_meta", "Other Details", "mentors_meta", "mentors-cpt", "normal", "low");
  add_meta_box("instructors_meta", "Other Details", "instructors_meta", "instructor-cpt", "normal", "low");
  add_meta_box("developerfellows_meta", "Other Details", "developerfellows_meta", "developerfellows-cpt", "normal", "low");  
}
/* code added to add custom fields in custom post types - ends */

/* code added to add custom fields for success stories - starts */
function success_stories_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $class = $custom["class"][0];
  $instructor = $custom["instructor"][0];
  ?>
  <p><label>Class:</label><br />
  <input name="class" size="50" value="<?php echo $class; ?>" /></p>
  <p><label>Instructor:</label><br />
  <input name="instructor" size="50" value="<?php echo $instructor; ?>" /></p>
  <?php
}

add_action('save_post', 'save_details');

function save_details(){
  global $post;
 
  update_post_meta($post->ID, "class", $_POST["class"]);
  update_post_meta($post->ID, "instructor", $_POST["instructor"]);
}
/* code added to add custom fields for success stories - ends */

/* code added to add custom fields for success showcase - starts */ 
function showcase_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $class = $custom["class"][0];
  $instructor = $custom["instructor"][0];
  $codepen = $custom["codepen"][0];
  ?>
  <p><label>Class:</label><br />
  <input name="class" size="50" value="<?php echo $class; ?>" /></p>
  <p><label>Instructor:</label><br />
  <input name="instructor" size="50" value="<?php echo $instructor; ?>" /></p>
  <p><label>Codepen Embed:</label><br />
  <textarea name="codepen" id="codepen" cols="50" rows="5"><?php echo $codepen; ?></textarea></p>
  <?php
}

add_action('save_post', 'save_showcase_details');

function save_showcase_details(){
  global $post;
 
  update_post_meta($post->ID, "class", $_POST["class"]);
  update_post_meta($post->ID, "instructor", $_POST["instructor"]);
  update_post_meta($post->ID, "codepen", $_POST["codepen"]);
}
/* code added to add custom fields for showcase - ends */

/* code added to add custom fields for mentors - starts */ 
function mentors_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  
  $designation = $custom["designation"][0];
  $company_name = $custom["company_name"][0];
  $work_experience = $custom["work_experience"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $geeky_fact = $custom["geeky_fact"][0];
  $students_think = $custom["students_think"][0];
  ?>
  <p><label>Designation:</label><br />
  <input name="designation" size="50" value="<?php echo $designation; ?>" /></p>
  <p><label>Company name:</label><br />
  <input name="company_name" size="50" value="<?php echo $company_name; ?>" /></p>
  <p><label>Work experience:</label><br />
  <textarea name="work_experience" id="work_experience" cols="50" rows="5"><?php echo $work_experience; ?></textarea></p>
  <p><label>Favorite tools:</label><br />
  <textarea name="favorite_tools" id="favorite_tools" cols="50" rows="5"><?php echo $favorite_tools; ?></textarea></p>
  <p><label>Geeky fact:</label><br />
  <textarea name="geeky_fact" id="geeky_fact" cols="50" rows="5"><?php echo $geeky_fact; ?></textarea></p>
  <p><label>What students think:</label><br />
  <textarea name="students_think" id="students_think" cols="50" rows="5"><?php echo $students_think; ?></textarea></p>
  <?php
}

add_action('save_post', 'save_mentors_details');

function save_mentors_details(){
  global $post;
 
  update_post_meta($post->ID, "designation", $_POST["designation"]);
  update_post_meta($post->ID, "company_name", $_POST["company_name"]);
  update_post_meta($post->ID, "work_experience", $_POST["work_experience"]);  
  update_post_meta($post->ID, "favorite_tools", $_POST["favorite_tools"]);
  update_post_meta($post->ID, "geeky_fact", $_POST["geeky_fact"]);
  update_post_meta($post->ID, "students_think", $_POST["students_think"]);
}
/* code added to add custom fields for mentors - ends */

/* code added to add custom fields for instructors - starts */ 
function instructors_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  
  $kung_fu = $custom["kung_fu"][0];
  $designation = $custom["designation"][0];
  $company_name = $custom["company_name"][0];
  $work_experience = $custom["work_experience"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $geeky_fact = $custom["geeky_fact"][0];
  $students_think = $custom["students_think"][0];
  ?>
  <p><label>Kung-fu:</label><br />
  <input name="kung_fu" size="50" value="<?php echo $kung_fu; ?>" /></p>
  <p><label>Designation:</label><br />
  <input name="designation" size="50" value="<?php echo $designation; ?>" /></p>
  <p><label>Company name:</label><br />
  <input name="company_name" size="50" value="<?php echo $company_name; ?>" /></p>
  <p><label>Work experience:</label><br />
  <textarea name="work_experience" id="work_experience" cols="50" rows="5"><?php echo $work_experience; ?></textarea></p>
  <p><label>Favorite tools:</label><br />
  <textarea name="favorite_tools" id="favorite_tools" cols="50" rows="5"><?php echo $favorite_tools; ?></textarea></p>
  <p><label>Geeky fact:</label><br />
  <textarea name="geeky_fact" id="geeky_fact" cols="50" rows="5"><?php echo $geeky_fact; ?></textarea></p>
  <p><label>What students think:</label><br />
  <textarea name="students_think" id="students_think" cols="50" rows="5"><?php echo $students_think; ?></textarea></p>
  <?php
}

add_action('save_post', 'save_instructors_details');

function save_instructors_details(){
  global $post;
 
  update_post_meta($post->ID, "kung_fu", $_POST["kung_fu"]);	
  update_post_meta($post->ID, "designation", $_POST["designation"]);
  update_post_meta($post->ID, "company_name", $_POST["company_name"]);
  update_post_meta($post->ID, "work_experience", $_POST["work_experience"]);  
  update_post_meta($post->ID, "favorite_tools", $_POST["favorite_tools"]);
  update_post_meta($post->ID, "geeky_fact", $_POST["geeky_fact"]);
  update_post_meta($post->ID, "students_think", $_POST["students_think"]);
}
/* code added to add custom fields for instructors - ends */

/* code added to add custom fields for developer fellows - starts */ 
function developerfellows_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  
  $years_coding = $custom["years_coding"][0];
  $kung_fu = $custom["kung_fu"][0];
  $designation = $custom["designation"][0];
  $company_name = $custom["company_name"][0];
  $work_experience = $custom["work_experience"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $favorite_tools = $custom["favorite_tools"][0];
  $geeky_fact = $custom["geeky_fact"][0];
  $students_think = $custom["students_think"][0];
  ?>
  
  <p><label>Years coding:</label><br />
  <input name="years_coding" size="50" value="<?php echo $years_coding; ?>" /></p>
  <p><label>Kung-fu:</label><br />
  <input name="kung_fu" size="50" value="<?php echo $kung_fu; ?>" /></p>
  <p><label>Designation:</label><br />
  <input name="designation" size="50" value="<?php echo $designation; ?>" /></p>
  <p><label>Company name:</label><br />
  <input name="company_name" size="50" value="<?php echo $company_name; ?>" /></p>
  <p><label>Work experience:</label><br />
  <textarea name="work_experience" id="work_experience" cols="50" rows="5"><?php echo $work_experience; ?></textarea></p>
  <p><label>Favorite tools:</label><br />
  <textarea name="favorite_tools" id="favorite_tools" cols="50" rows="5"><?php echo $favorite_tools; ?></textarea></p>
  <p><label>Geeky fact:</label><br />
  <textarea name="geeky_fact" id="geeky_fact" cols="50" rows="5"><?php echo $geeky_fact; ?></textarea></p>
  <p><label>What students think:</label><br />
  <textarea name="students_think" id="students_think" cols="50" rows="5"><?php echo $students_think; ?></textarea></p>
  <?php
}

add_action('save_post', 'save_developerfellows_details');

function save_developerfellows_details(){
  global $post;
  
  update_post_meta($post->ID, "years_coding", $_POST["years_coding"]);
  update_post_meta($post->ID, "kung_fu", $_POST["kung_fu"]);	
  update_post_meta($post->ID, "designation", $_POST["designation"]);
  update_post_meta($post->ID, "company_name", $_POST["company_name"]);
  update_post_meta($post->ID, "work_experience", $_POST["work_experience"]);  
  update_post_meta($post->ID, "favorite_tools", $_POST["favorite_tools"]);
  update_post_meta($post->ID, "geeky_fact", $_POST["geeky_fact"]);
  update_post_meta($post->ID, "students_think", $_POST["students_think"]);
}
/* code added to add custom fields for developer fellows - ends */

/* code added to add custom pagination - starts */
function pagination_bar($max_num_pages) {
    global $wp_query;
 
    $total_pages = $max_num_pages; //$wp_query->max_num_pages;
 
    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
 
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
			'prev_next'          => true,
			'prev_text'          => __('Previous'),
			'next_text'          => __('Next'),
			'type'               => 'plain',
        ));
    }
}
/* code added to add custom pagination - ends */



//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );




// Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}