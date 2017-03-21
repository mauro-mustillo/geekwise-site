<?php

/**

 * The template for displaying the footer

 *

 * Contains the closing of the #content div and all content after

 *

 * @package WordPress

 * @subpackage Twenty_Sixteen

 * @since Twenty Sixteen 1.0

 */

?>



		</div><!-- .site-content -->


		<footer id="colophon" class="site-footer" role="contentinfo">

        

        	<div class="container">

                <div class="row">

                    <?php dynamic_sidebar('contact-info'); ?>

                    <?php dynamic_sidebar('newsletter'); ?>

                    <?php dynamic_sidebar('recent-news'); ?>

                </div>

            </div>

            

<?php /*?>			<?php if ( has_nav_menu( 'primary' ) ) : ?>

				<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">

					<?php

						wp_nav_menu( array(

							'theme_location' => 'primary',

							'menu_class'     => 'primary-menu',

						 ) );

					?>

				</nav>

			<?php endif; ?><?php */?>

            <!-- .main-navigation -->



			<?php /*?><?php if ( has_nav_menu( 'social' ) ) : ?>

				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">

					<?php

						wp_nav_menu( array(

							'theme_location' => 'social',

							'menu_class'     => 'social-links-menu',

							'depth'          => 1,

							'link_before'    => '<span class="screen-reader-text">',

							'link_after'     => '</span>',

						) );

					?>

				</nav><!-- .social-navigation -->

			<?php endif; ?><?php */?>



			<?php /*?><div class="site-info col-sm-12">

				<?php

					do_action( 'twentysixteen_credits' );

				?>

				<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>

				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentysixteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentysixteen' ), 'WordPress' ); ?></a>

			</div><!-- .site-info --><?php */?>

		</footer><!-- .site-footer -->

        

        <?php dynamic_sidebar('footer-copyright'); ?>

        

	</div><!-- .site-inner -->

</div><!-- .site -->



<?php wp_footer(); ?>



<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="<?php bloginfo("template_url"); ?>/js/bootstrap.min.js"></script>

<script src="<?php bloginfo("template_url"); ?>/js/typed.js"></script>

<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.jcarousel.min.js"></script>

<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jcarousel.responsive.js"></script>
<script>
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();
if (scroll >= 10) {
 jQuery(".site-header-wrapper").addClass("fixed");
  jQuery(".site").addClass("scroll");
 } else {
 jQuery(".site-header-wrapper").removeClass("fixed");
 jQuery(".site").removeClass("scroll");
}
});
</script>
<script src="<?php bloginfo("template_url"); ?>/js/general.js"></script>


<script>
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();
if (scroll >= 100) {
 jQuery("#header-home-bg").addClass("transparent");
  
 } else {
 jQuery("#header-home-bg").removeClass("transparent");
}
});
</script>
<script>
jQuery(window).scroll(function() {    
    var scroll = jQuery(window).scrollTop();
if (scroll >= 900) {
 jQuery("#header-home-bg").addClass("change");
  
 } else {
 jQuery("#header-home-bg").removeClass("change");
}
});
</script>



<?php global $template; echo '<!-- ' . $template . ' -->'; ?>
<script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-41945829-2', 'geekwiseacademy.com');
          ga('send', 'pageview');

        </script>
</body>

</html>