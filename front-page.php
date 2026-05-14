<?php
/**
 * The front page template file
 */

get_header();
?>

	<main id="primary" class="site-main">

		<div class="container" style="padding: 40px 0;">
			
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					
					// If the user hasn't added any content yet, show a default message/layout
					$content = get_the_content();
					if ( empty($content) ) {
						?>
						<!-- Default Fallback Hero Section -->
						<section class="hero-section">
							<h2>Premium Rajshahi Mangoes</h2>
							<p>100% Chemical-Free, Fresh from the Orchard to Your Home.</p>
							<?php if ( class_exists( 'WooCommerce' ) ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">Order Now</a>
							<?php endif; ?>
						</section>

						<div style="text-align:center; padding: 50px 0;">
							<h3>Welcome to Shulov Park!</h3>
							<p>To edit this page, go to <strong>WP Admin > Pages > Home</strong> and add your images, rows, and use the shortcode <code>[products]</code> to display products.</p>
						</div>
						<?php
					} else {
						// Output the content from WP Admin Editor
						the_content();
					}

				endwhile;
			else :
				// Fallback if no page exists
				echo '<p>Please create a Home page in WP Admin and set it as your static front page.</p>';
			endif;
			?>

		</div><!-- .container -->

	</main><!-- #main -->

<?php
get_footer();
