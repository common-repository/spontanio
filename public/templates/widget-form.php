<p>
	<label for="<?php echo esc_attr( $buttonNameFieldName ); ?>">Button Name <i>(3+ chars)</i>:</label>
	<br>
	<input id="<?php echo esc_attr( $buttonNameFieldId ); ?>" name="<?php echo esc_attr( $buttonNameFieldName); ?>" type="text" value="<?php echo esc_attr( $buttonName ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $roomNameFieldName ); ?>">Room Name <i>(6+ alphanumerical chars)</i>:</label>
	<br>
	<input id="<?php echo esc_attr( $roomNameFieldId ); ?>" name="<?php echo esc_attr( $roomNameFieldName); ?>" type="text" value="<?php echo esc_attr( $roomName ); ?>" />
</p>
<p>
	<label for="<?php echo esc_attr( $heightFieldName ); ?>">Height <i>(min: 300px; max: 100%)</i>:</label>
	<br>
	<input style="margin-bottom: 8px;" id="<?php echo esc_attr( $heightFieldId ); ?>" name="<?php echo esc_attr( $heightFieldName ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
	<select style="margin-top: -3px;" id="<?php echo esc_attr( $heightUnitsFieldId ); ?>" name="<?php echo esc_attr( $heightUnitsFieldName ); ?>">
		<option value="px" <?php echo ($heightUnits == 'px') ? 'selected' : ''; ?>>px</option>
		<option value="%" <?php echo ($heightUnits == '%') ? 'selected' : ''; ?>>%</option>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $widthFieldName ); ?>">Width <i>(min: 300px; max: 100%)</i>:</label>
	<br>
	<input style="margin-bottom: 8px;" id="<?php echo esc_attr( $widthFieldId ); ?>" name="<?php echo esc_attr( $widthFieldName ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" />
	<select style="margin-top: -3px;" id="<?php echo esc_attr( $widthUnitsFieldId ); ?>" name="<?php echo esc_attr( $widthUnitsFieldName ); ?>">
		<option value="px" <?php echo ($widthUnits == 'px') ? 'selected' : ''; ?>>px</option>
		<option value="%" <?php echo ($widthUnits == '%') ? 'selected' : ''; ?>>%</option>
	</select>
</p>
<p>
	Position:
	<div style="display: flex; flex-direction: row; flex-wrap: wrap;">
		<div style="padding-right: 15px; margin-bottom: 15px;">
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-left-top" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-left-top' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Left Top
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-left-middle" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-left-middle' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Left Middle
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-left-bottom" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-left-bottom' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Left Bottom
			</label>
		</div>
		<div style="padding-right: 15px; margin-bottom: 15px;">
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-center-top" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-center-top' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Center Top
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-center-middle" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-center-middle' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Center Middle
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-center-bottom" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-center-bottom' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Center Bottom
			</label>
		</div>
		<div style="padding-right: 15px; margin-bottom: 15px;">
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-right-top" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-right-top' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Right Top
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-right-middle" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-right-middle' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Right Middle
			</label>
			<label style="display: block; padding-bottom: 5px">
				<input type="radio" value="spontanio-right-bottom" name="<?php echo esc_attr( $positionFieldName ); ?>" <?php checked( $position, 'spontanio-right-bottom' ); ?> id="<?php echo esc_attr( $positionFieldId ); ?>" />
				Right Bottom
			</label>
		</div>
	</div>
</p>