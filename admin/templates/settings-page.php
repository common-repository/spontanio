<div>
	<h1>
		<svg style="vertical-align:middle" width="32" height="32" version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 2000 2000" xml:space="preserve">
			<title>Spontanio Logo</title>
			<g>
				<path d="m 343.38086,1555.1179 q 22.31015,0 52.05702,33.4653 92.95899,101.6351 226.81992,163.6078 135.10038,60.7332 266.4824,60.7332 145.016,0 145.016,-88.0012 0,-55.7754 -50.8176,-125.1848 Q 932.1211,1529.0894 740.00584,1322.1008 498.31249,1060.5762 417.74804,934.15192 311.15508,766.82576 311.15508,615.61248 q 0,-228.05936 203.2703,-373.07537 Q 713.97733,100 1006.4883,100 q 204.5097,0 375.5542,83.04336 64.4516,32.22578 110.3114,74.36718 47.0992,42.14141 47.0992,70.64883 0,13.63398 -13.634,26.02851 -12.3945,11.15508 -26.0285,11.15508 -21.0707,0 -61.9727,-38.42305 -66.9304,-63.2121 -176.0023,-104.11405 -109.0719,-42.14141 -209.4676,-42.14141 -61.9726,0 -101.6351,27.26797 -38.4231,26.02851 -38.4231,68.16992 0,50.81757 48.3387,123.94531 48.3387,73.12773 163.6078,194.59413 364.3992,387.9488 446.2031,523.04922 85.5223,142.5371 85.5223,275.1586 0,112.7902 -60.7332,213.1859 -60.7332,100.3957 -168.5657,164.8473 -205.7492,122.7058 -501.9785,122.7058 -272.67963,0 -479.66829,-141.2976 Q 300,1653.0347 300,1597.2593 q 0,-16.1129 12.39453,-28.5074 13.63398,-13.634 30.98633,-13.634 z"
					fill="#e36c0a"/>
				<path d="m 700,997.95508 c 0,-145.96432 118.4638,-264.42822 264.4282,-264.42822 146.0965,0 264.4281,118.4639 264.4281,264.42822 0,146.09662 -118.3316,264.42822 -264.4281,264.42822 C 818.4638,1262.3833 700,1144.0517 700,997.95508 Z"
 					fill="#800000" />
			</g>
		</svg>
		Thanks for choosing Spontanio!
	</h1>
	<?php if ( ! is_ssl() ): ?>
		<div class="notice notice-warning settings-warning">
			<p><strong>Spontanio requires HTTPS (SSL).</strong></p>
			<p>To protect the privacy of you and your visitors, Spontanio will only work on sites
			that use SSL encryption. You can continue working with this plugin, but if users
			are not connected with HTTPS, they will not be able to join chats.
			It's <a href="https://letsencrypt.org/" target="_blank">free and easy</a> to secure your site!</p>
		</div>
	<?php endif; ?>
	<?php
		$errors_messages = array_unique( get_settings_errors(), SORT_REGULAR );
		foreach ( $errors_messages as $errors_message ) {
			if ( ( $message = $errors_message['message'] ) && ( $errors_message['type'] === 'error' ) ):
	?>
				<div id="setting-error-" class="notice notice-error settings-error is-dismissible">
					<p><strong><?php echo esc_html( $message ); ?></strong></p>
				</div>
	<?php
			elseif ( ( $message = $errors_message['message'] ) && ( $errors_message['type'] === 'success' ) ):
	?>
				<div id="setting-success-" class="notice notice-success settings-success is-dismissible">
					<p><strong><?php echo esc_html( $message ); ?></strong></p>
				</div>
	<?php
			endif;
		}
	?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form action="options.php" method="POST">
		<?php
			settings_fields( SpontanioAdmin::OPTION_GROUP );
			do_settings_sections( SpontanioAdmin::OPTION_GROUP );
			submit_button( 'Save Changes' );
		?>
	</form>
</div>