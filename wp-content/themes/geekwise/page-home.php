<?php /* Template Name: Home Page */ ?>

<?php get_header('front-page'); ?>

<div class="container-fluid no-side-padding">


<h1 class="entry-title"><span><?php the_title(); ?></span></h1> 
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>
       <div class="home-instructors-back"> 
        <div class="container">
        <section class="home-instructors col-sm-12">
        	<h2>SOCIAL NETWORKS</h2>
        	<BR/><BR/>
        	<div class="row">
			
       	<div class="col-md-6">
       	<div class="fb-page" data-href="https://www.facebook.com/GeekwiseAcademy/" data-tabs="timeline" data-width="600" data-height="500" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"  style="margin-left: 50px"><blockquote cite="https://www.facebook.com/GeekwiseAcademy/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/GeekwiseAcademy/">Geekwise Academy</a></blockquote></div>
       	</div>
       		<div class="col-md-6"><a class="twitter-timeline" data-width="500" data-height="500" href="https://twitter.com/GeekwiseAcademy">Tweets by GeekwiseAcademy</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
       	</div>
        	
        		</div>
        	
        	
        	
        	
        	
        	
        	
        </section>
        </div></div>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
</div>
<?php get_footer('home'); ?>
