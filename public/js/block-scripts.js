( function ( blocks, element, blockEditor ) {
	var el = element.createElement;

	var iconElement = el( 'svg', {
			width: 24,
			height: 24,
			version: '1.2',
			baseProfile: 'tiny-ps',
			xmlns: 'http://www.w3.org/2000/svg',
			viewBox: '0 0 2000 2000',
			'xml:space': 'preserve'
		},
		el( 'title', null, 'Spontanio Logo' ),
		el( 'g', null,
			el( 'path', { fill: 'black', d: 'm 343.38086,1555.1179 q 22.31015,0 52.05702,33.4653 92.95899,101.6351 226.81992,163.6078 135.10038,60.7332 266.4824,60.7332 145.016,0 145.016,-88.0012 0,-55.7754 -50.8176,-125.1848 Q 932.1211,1529.0894 740.00584,1322.1008 498.31249,1060.5762 417.74804,934.15192 311.15508,766.82576 311.15508,615.61248 q 0,-228.05936 203.2703,-373.07537 Q 713.97733,100 1006.4883,100 q 204.5097,0 375.5542,83.04336 64.4516,32.22578 110.3114,74.36718 47.0992,42.14141 47.0992,70.64883 0,13.63398 -13.634,26.02851 -12.3945,11.15508 -26.0285,11.15508 -21.0707,0 -61.9727,-38.42305 -66.9304,-63.2121 -176.0023,-104.11405 -109.0719,-42.14141 -209.4676,-42.14141 -61.9726,0 -101.6351,27.26797 -38.4231,26.02851 -38.4231,68.16992 0,50.81757 48.3387,123.94531 48.3387,73.12773 163.6078,194.59413 364.3992,387.9488 446.2031,523.04922 85.5223,142.5371 85.5223,275.1586 0,112.7902 -60.7332,213.1859 -60.7332,100.3957 -168.5657,164.8473 -205.7492,122.7058 -501.9785,122.7058 -272.67963,0 -479.66829,-141.2976 Q 300,1653.0347 300,1597.2593 q 0,-16.1129 12.39453,-28.5074 13.63398,-13.634 30.98633,-13.634 z' } ),
			el( 'path', { fill: 'white', d: 'm 700,997.95508 c 0,-145.96432 118.4638,-264.42822 264.4282,-264.42822 146.0965,0 264.4281,118.4639 264.4281,264.42822 0,146.09662 -118.3316,264.42822 -264.4281,264.42822 C 818.4638,1262.3833 700,1144.0517 700,997.95508 Z' } )
		)
	);

	blocks.registerBlockType( 'spontanio/iframe-block', {
		//built-in attributes
		title: 'Video Chat',
		description: 'Adds video chat to your page',
		icon: iconElement,
		category: 'widgets',

		//custom attributes
		attributes: {
			isButton: { type: 'boolean', default: false },
			isOnload: { type: 'boolean', default: true },
			isWidthUnitsPx: { type: 'boolean', default: false },
			isWidthUnitsPercent: { type: 'boolean', default: true },
			isHeightUnitsPx: { type: 'boolean', default: false },
			isHeightUnitsPercent: { type: 'boolean', default: true },

			buttonName: { type: 'string', default: 'Video Chat' },
			roomName: { type: 'string', default: options['default_name'] },

			widthValue: { type: 'string', default: '100' },
			widthUnits: { type: 'array', source: 'children', selector: 'p' },

			heightValue: { type: 'string', default: '100' },
			heightUnits: { type: 'array', source: 'children', selector: 'p' },

			position: { type: 'string', default: 'spontanio-center-middle' },
		},

		edit: function( props ) {
			// How block renders in the editor in edit mode
			function updateIsButton( event ) {
				props.setAttributes( { isButton: true } );
				props.setAttributes( { isOnload: false } );
			}
			function updateIsOnload( event ) {
				props.setAttributes( { isButton: false } );
				props.setAttributes( { isOnload: true } );
			}

			function updateButtonName( event ) {
				props.setAttributes( { buttonName: event.target.value } );
			}
			function validateButtonName( event ) {
				var nameLength = event.target.value.length;
				if ( nameLength < 3 ) {
					props.setAttributes( { buttonName: 'Video Chat' } );
				}
			}

			function updateRoomName( event ) {
				props.setAttributes( { roomName: event.target.value } );
			}
			function validateRoomName( event ) {
				var convertedName = event.target.value.toLowerCase().replace( /[^0-9a-z]/gi, '' );
				if ( convertedName.length < 6 ) {
					props.setAttributes( { roomName: options['default_name'] } );
				} else {
					props.setAttributes( { roomName: event.target.value } );
				}
			}

			function updateWidthValue( event ) {
				props.setAttributes( { widthValue: event.target.value } );
			}
			function validateWidth( event ) {
				if ( parseInt( event.target.value ) < 20 ) {
					props.setAttributes( { widthValue: '100' } );
				}
			}
			function updateWidthUnits( event ) {
				var unitsWidth = event.target.value;
				props.setAttributes( { widthUnits: unitsWidth } );
				if ( unitsWidth === 'px' ) {
					props.setAttributes( { isWidthUnitsPx: true } );
					props.setAttributes( { isWidthUnitsPercent: false } );
					if ( props.attributes.widthValue < 300 ) {
						props.setAttributes( { widthValue: '300' } );
					}
				} else {
					props.setAttributes( { isWidthUnitsPx: false } );
					props.setAttributes( { isWidthUnitsPercent: true } );
					if ( ( props.attributes.widthValue < 20 ) || ( props.attributes.widthValue > 100 ) ) {
						props.setAttributes( { widthValue: '100' } );
					}
				}
			}

			function updateHeightValue( event ) {
				props.setAttributes( { heightValue: event.target.value } );
			}
			function validateHeight( event ) {
				if ( parseInt( event.target.value ) < 20 ) {
					props.setAttributes( { heightValue: '100' } );
				}
			}
			function updateHeightUnits( event ) {
				var unitsHeight = event.target.value;
				props.setAttributes( { heightUnits: unitsHeight } );
				if ( unitsHeight === 'px' ) {
					props.setAttributes( { isHeightUnitsPx: true } );
					props.setAttributes( { isHeightUnitsPercent: false } );
					if ( props.attributes.heightValue < 300 ) {
						props.setAttributes( { heightValue: '300' } );
					}
				} else {
					props.setAttributes( { isHeightUnitsPx: false } );
					props.setAttributes( { isHeightUnitsPercent: true } );
					if ( ( props.attributes.heightValue < 20 ) || ( props.attributes.heightValue > 100 ) ) {
						props.setAttributes( { heightValue: '100' } );
					}
				}
			}

			function updatePosition( event ) {
				props.setAttributes( { position: event.target.value } );
			}

			return el( 'div', { className: 'spontanio-block-form' },
				// Radio buttons
				el( 'h4', null, 'Spontanio Video Chat' ),
				el( 'p', null, 'Specify how Video Chat will be displayed on your site.' ),
				el( 'hr' ),

				// room name input
				el( 'label', null,
					'Room Name',
					el( 'i', { style: { 'font-size': '13px' } }, ' (6+ alphanumerical chars)' ),
					el( 'input', {
						type: 'text',
						placeholder: 'Enter room name here...',
						value: props.attributes.roomName,
						onChange: updateRoomName,
						onBlur: validateRoomName,
						style: { width: '95%' },
					} )
				),
				el( 'hr' ),

				// radiobuttons block
				el( 'div', { className: 'spontanio-radios-block' },
					el( 'label', null,
						el( 'input', {
							type: 'radio',
							onChange: updateIsOnload,
							name: 'block-view',
							value: 'button',
							className: 'spontanio-first',
							checked: props.attributes.isOnload
						} ),
						'Launch video chat on page load'
					),
					el( 'label', null,
						el( 'input', {
							type: 'radio',
							onChange: updateIsButton,
							name: 'block-view',
							value: 'button',
							checked: props.attributes.isButton
						} ),
						'Show button to launch'
					)
				),

				// button name input
				el( 'label', { hidden: !props.attributes.isButton },
					'Button Text',
					el( 'i', { style: { 'font-size': '13px' } }, ' (3+ chars)' ),
					el( 'input', {
						type: 'text',
						placeholder: 'Enter button text here...',
						value: props.attributes.buttonName,
						onChange: updateButtonName,
						onBlur: validateButtonName,
						style: { width: '95%' },
					} )
				),
				
				// width block
				el( 'div', { className: 'spontanio-width-block' },
					el( 'label', null,
						'Width',
						el( 'input', {
							type: 'number',
							value: props.attributes.widthValue,
							onChange: updateWidthValue,
							onBlur: validateWidth,
							style: { width: '20%' }
						} ),
						el( 'select', {
								onChange: updateWidthUnits,
								style: { width: '15%' }
							},
							el( 'option', {
								value: 'px',
								selected: props.attributes.isWidthUnitsPx
							}, 'px' ),
							el( 'option', {
								value: '%',
								selected: props.attributes.isWidthUnitsPercent
							}, '%' )
						),
						el( 'i', { style: { 'font-size': '13px' } }, ' (min: 300px; max: 100%)' )
					)
				),

				// height block
				el( 'div', { className: 'spontanio-height-block' },
					el( 'label', null,
						'Height',
						el( 'input', {
							type: 'number',
							value: props.attributes.heightValue,
							onChange: updateHeightValue,
							onBlur: validateHeight,
							style: { width: '20%' }
						} ),
						el( 'select', {
								onChange: updateHeightUnits,
								style: { width: '15%' }
							},
							el( 'option', {
								value: 'px',
								selected: props.attributes.isHeightUnitsPx
							}, 'px' ),
							el( 'option', {
								value: '%',
								selected: props.attributes.isHeightUnitsPercent
							}, '%' )
						),
						el( 'i', { style: { 'font-size': '13px' } }, ' (min: 300px; max: 100%)' )
					)
				),

				// radiobuttons position block
				el ( 'div', null,
					el( 'div', { style: { 'margin-left': '15px' } }, 'Position' ),
					el( 'div', { className: 'spontanio-flex-box' },
						el( 'div', { className: 'spontanio-flex-column' },
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									className: 'spontanio-first',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-left-top',
									checked: props.attributes.position === 'spontanio-left-top'
								} ),
								'Left Top'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									className: 'spontanio-first',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-left-middle',
									checked: props.attributes.position === 'spontanio-left-middle'
								} ),
								'Left Middle'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									className: 'spontanio-first',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-left-bottom',
									checked: props.attributes.position === 'spontanio-left-bottom'
								} ),
								'Left Bottom'
							)
						),
						el( 'div', { className: 'spontanio-flex-column' },
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-center-top',
									checked: props.attributes.position === 'spontanio-center-top'
								} ),
								'Center Top'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-center-middle',
									checked: props.attributes.position === 'spontanio-center-middle'
								} ),
								'Center Middle'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-center-bottom',
									checked: props.attributes.position === 'spontanio-center-bottom'
								} ),
								'Center Bottom'
							)
						),
						el( 'div', { className: 'spontanio-flex-column' },
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-right-top',
									checked: props.attributes.position === 'spontanio-right-top'
								} ),
								'Right Top'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-right-middle',
									checked: props.attributes.position === 'spontanio-right-middle'
								} ),
								'Right Middle'
							),
							el( 'label', null,
								el( 'input', {
									type: 'radio',
									onChange: updatePosition,
									name: 'position',
									value: 'spontanio-right-bottom',
									checked: props.attributes.position === 'spontanio-right-bottom'
								} ),
								'Right Bottom'
							)
						)
					)
				)
			);
		},

		save: function( props ) {
			// How block renders on the frontend
			var displayedHeight = parseInt( props.attributes.heightValue );
			var displayedWidth = parseInt( props.attributes.widthValue );

			if ( props.attributes.isHeightUnitsPercent && ( displayedHeight < 20 || displayedHeight > 100 ) ) {
				props.attributes.heightValue = '100';
			}
			if ( props.attributes.isHeightUnitsPx && displayedHeight < 300 ) {
				props.attributes.heightValue = '300';
			}
			if ( props.attributes.isWidthUnitsPercent && ( displayedWidth < 20 || displayedWidth > 100 ) ) {
				props.attributes.widthValue = '100';
			}
			if ( props.attributes.isWidthUnitsPx && displayedWidth < 300 ) {
				props.attributes.widthValue = '300';
			}

			var heightStyle = props.attributes.isHeightUnitsPercent ? props.attributes.heightValue + '%' : props.attributes.heightValue + 'px';
			var widthStyle = props.attributes.isWidthUnitsPercent ? props.attributes.widthValue + '%' : props.attributes.widthValue + 'px';

			if ( props.attributes.roomName.length ) {
				var convertedName = props.attributes.roomName.toLowerCase().replace( /[^0-9a-z]/gi, '' );
				if ( convertedName.length >= 6 && convertedName !== options['default_name'].toLowerCase().replace( /[^0-9a-z]/gi, '' ) ) {
					var uriRoomName = convertedName;
				}
			}

			var wrapElId = 'spontanio-onload';
			if ( props.attributes.isButton ) {
				wrapElId = 'spontanio-block';
			}

			var onloadClass = '';
			if ( props.attributes.isOnload ) {
				onloadClass = 'spontanio-onload-data';
			}

			var buttonEl = el( 'button', {
				type: 'button',
				id: 'spontanio-block-button',
				className: 'spontanio-button'
			}, props.attributes.buttonName );

			var wrapEl = el( 'div', {
					id: 'spontanio-block-data',
					className: onloadClass,
					'data-id': wrapElId,
					'data-position': props.attributes.position,
					'data-roomname': uriRoomName,
					'data-width': widthStyle,
					'data-height': heightStyle,
				}
			);

			if ( props.attributes.isOnload ) {
				return el( 'div', null, wrapEl );
			} else {
				return el( 'div', null, buttonEl, wrapEl );
			}
		}
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );