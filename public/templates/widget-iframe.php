<?php
	echo $args['before_widget'];
	echo $args['before_title'];
	echo $args['after_title'];
?>
<button type="button" id="spontanio-widget-button" class="spontanio-button"><?php echo esc_html( $buttonName ); ?></button>
	<div id="spontanio-widget-data"
		data-id="spontanio-widget"
		data-position="<?php echo esc_attr( $position ); ?>"
		data-roomname = "<?php echo esc_attr( $roomName ); ?>"
		data-width="<?php echo esc_attr( $width ); ?>"
		data-height="<?php echo esc_attr( $height ); ?>"
	>
	</div>
<?php
	echo $args['after_widget'];
