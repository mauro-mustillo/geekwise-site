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



<footer class="footer-sales container">
	<div class="col-sm-6">*Refunds available only for life-events.</div>
    <div class="col-sm-6"><img src="<?php bloginfo("template_url"); ?>/images/icon-stripe.png" alt=" " /></div>
    </div>
</footer>


		<footer id="colophon" class="site-footer" role="contentinfo" style="display:none; height:; overflow:hidden">

        

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

        

        <?php //dynamic_sidebar('footer-copyright'); ?>

        

	</div><!-- .site-inner -->

</div><!-- .site -->



<?php wp_footer(); ?>



<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script src="<?php bloginfo("template_url"); ?>/js/bootstrap.min.js"></script>

<script src="<?php bloginfo("template_url"); ?>/js/typed.js"></script>

<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.jcarousel.min.js"></script>

<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jcarousel.responsive.js"></script>

<script src="<?php bloginfo("template_url"); ?>/js/general.js"></script>



<!---------------------------------------
-----------------------------------------
            S T R I P E
-----------------------------------------
---------------------------------------->

<script type="text/javascript">
  Stripe.setPublishableKey('pk_test_bgrSAB1K9P16FUWdWUXbnAwh');
</script>
<script type="text/javascript">
jQuery(function() {
  var $form = jQuery('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});
</script>
<script  type="text/javascript">
function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = jQuery('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID into the form so it gets submitted to the server:
    $form.append(jQuery('<input type="hidden" name="stripeToken">').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};
</script>
<script type="text/javascript">
jQuery('#payment-form').validator().on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    if( jQuery('#student_name').val() == '' || jQuery('#student_email').val() == '' || jQuery('#student_phone').val() == '') {
      jQuery("a[href='#enter-email']").tab('show');
    }
  } 
})
</script>
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
</body>

</html>

