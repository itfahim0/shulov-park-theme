	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-widgets">
				<div class="footer-widget">
					<h3 class="widget-title">About Shulov Park</h3>
					<p>Providing the best quality grocery and organic food items across the country. Order fresh, order healthy.</p>
				</div>
				<div class="footer-widget">
					<h3 class="widget-title">Quick Links</h3>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Shop</a></li>
							<li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Cart</a></li>
							<li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">Checkout</a></li>
							<li><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">My Account</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="footer-widget">
					<h3 class="widget-title">Contact Us</h3>
					<ul>
						<li>📞 <?php echo esc_html( get_theme_mod( 'footer_support_phone', '+880 1234-567890' ) ); ?></li>
						<li>📧 support@shulovpark.com</li>
						<li>📍 Dhaka, Bangladesh</li>
					</ul>
				</div>
			</div><!-- .footer-widgets -->
			
			<div class="site-info" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid #444;">
				<div class="copyright">
					<p>&copy; <?php echo date('Y'); ?> Shulov Park. All rights reserved. | Developed By <a href="https://github.com/itfahim0" target="_blank" style="color: var(--primary-color);">@itfahim0</a></p>
				</div>
				<div class="payment-methods-container" style="display: flex; align-items: center; gap: 15px;">
					<span style="font-weight: bold; color: #fff;">Pay With</span>
					<div class="payment-methods" style="display: flex; gap: 8px; flex-wrap: wrap;">
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" style="max-width: 100%; max-height: 100%;"></div>
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" alt="Mastercard" style="max-width: 100%; max-height: 100%;"></div>
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/American_Express_logo_%282018%29.svg" alt="Amex" style="max-width: 100%; max-height: 100%;"></div>
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://upload.wikimedia.org/wikipedia/commons/7/74/Nagad_Logo_2019.svg" alt="Nagad" style="max-width: 100%; max-height: 100%;"></div>
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://seeklogo.com/images/B/bkash-logo-FBB258B90F-seeklogo.com.png" alt="bKash" style="max-width: 100%; max-height: 100%;"></div>
						<div style="background:#fff; width: 50px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 4px; padding: 5px;"><img src="https://seeklogo.com/images/D/dutch-bangla-rocket-logo-B4D13693EE-seeklogo.com.png" alt="Rocket" style="max-width: 100%; max-height: 100%;"></div>
					</div>
				</div>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
