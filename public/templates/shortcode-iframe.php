<div>
	<?php if ( ! $autoLaunch ): ?>
	<button type="button" id="spontanio-shortcode-button" class="spontanio-button"><?php echo esc_html( $buttonText ); ?></button>
	<?php endif; ?>

	<div id="spontanio-shortcode-data"
		<?php echo $autoLaunch ? 'class="spontanio-onload-data"' : ''; ?>
		data-id="<?php echo $autoLaunch ? 'spontanio-onload' : 'spontanio-shortcode'; ?>"
		data-position="<?php echo esc_attr( $position ); ?>"
		data-roomname = "<?php echo esc_attr( $roomName ); ?>"
		data-width="<?php echo esc_attr( $width ); ?>"
		data-height="<?php echo esc_attr( $height ); ?>"
	>
	</div>
</div>