document.addEventListener("DOMContentLoaded", function() {
	var iframeContainer;
	var closeButtons = [];
	var buttons = document.querySelectorAll( '.spontanio-button' );

	var widgetWrap = document.querySelector( '#spontanio-widget-data' );
	var shortcodeWrap = document.querySelector( '#spontanio-shortcode-data' );
	var blockWrap = document.querySelector( '#spontanio-block-data' );

	if (
		shortcodeWrap !== null &&
		blockWrap !== null &&
		shortcodeWrap.classList.contains( 'spontanio-onload-data' ) &&
		blockWrap.classList.contains( 'spontanio-onload-data' )
	) {
		addPopupContainer( document.querySelector( '.spontanio-onload-data' ) );
	} else {
		addPopupContainer( blockWrap );
		addPopupContainer( shortcodeWrap );
	}

	addPopupContainer( widgetWrap );

	buttons.forEach(function ( button ) {
		button.addEventListener('click', spontanioOpen);
	})

	closeButtons.forEach(function ( button ) {
		button.addEventListener('click', spontanioClose);
	})

	var onloadContainer = document.querySelector( '#spontanio-onload' );
	if ( onloadContainer !== null ) {
		addIframe( onloadContainer.id );
		if ( buttons.length ) {
			buttons.forEach( function ( button ) {
				button.setAttribute( 'disabled', 'disabled' );
			});
		}
	}

	// add containers for each used on the page element of plugin (block, shortcode, widget)
	function addPopupContainer( elementData ) {
		if ( elementData !== null ) {
			var elementWrap = document.createElement( 'div' );
			elementWrap.setAttribute( 'id', elementData.dataset.id );
			elementWrap.setAttribute( 'class', 'spontanio-container ' + elementData.dataset.position );
			elementWrap.setAttribute( 'data-roomname', elementData.dataset.roomname );
			elementWrap.style.maxWidth = '100%';
			elementWrap.style.maxHeight = '100%';
			elementWrap.style.width = elementData.dataset.width;
			elementWrap.style.height = elementData.dataset.height;
			elementWrap.innerHTML =
				'<div id="'+ elementWrap.id +'-title" class="spontanio-title">\n' +
					'<p>Video chat</p>\n' +
					'<span id="' + elementWrap.id + '-close">\n' +
					'<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">\n' +
						'<path d="M0 0h24v24H0V0z" fill="none"/>\n' +
						'<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>\n' +
					'</svg>\n' +
					'</span>\n' +
				'</div>';
			document.body.append( elementWrap );

			closeButtons.push( document.querySelector( '#'+ elementWrap.id +'-close' ) );
		}
	}

	// define elements behavior when popup should be opened
	function spontanioOpen( event ) {
		buttons.forEach( function ( button ) {
			button.setAttribute( 'disabled', 'disabled' );
		} );
		addIframe( event.target.id );
	}

	// define elements behavior when popup close button has been clicked
	function spontanioClose( event ) {
		if ( buttons.length ) {
			buttons.forEach(function (button) {
				button.removeAttribute( 'disabled' );
			});
		}
		removeIframe( event.target.parentElement.id );
	}

	// add iFrame to the page
	function addIframe( id ) {
		switch ( id ) {
			case 'spontanio-widget-button':
				iframeContainer = document.querySelector( '#spontanio-widget' );
				break;
			case 'spontanio-block-button':
				iframeContainer = document.querySelector( '#spontanio-block' );
				break;
			case 'spontanio-shortcode-button':
				iframeContainer = document.querySelector( '#spontanio-shortcode' );
				break;
			case 'spontanio-onload':
				iframeContainer = onloadContainer;
				break;
		}

		iframeContainer.style.display = 'block';
		var iframeNode;
		var spontanioTitle = document.querySelector( '#' + iframeContainer.id + '-title' );
		if ( location.protocol === 'https:' ) {
			iframeNode = document.createElement( 'iframe' );
			var roomName = iframeContainer.dataset.roomname;
			if ( roomName === undefined || roomName === 'undefined' ) {
				roomName = document.querySelector('#default-room-name').dataset.defaultroomname;
			}
			iframeNode.setAttribute( 'id', iframeContainer.id + '-iframe' );
			iframeNode.setAttribute( 'allow', 'camera *; microphone *' );
			iframeNode.setAttribute( 'src', 'https://spontan.io/' + roomName + '/embed?url=' + encodeURI(document.location.href) );
			iframeNode.setAttribute( 'title', 'spontanio-iframe' );
			iframeNode.setAttribute( 'width', '100%' );
			iframeNode.setAttribute( 'style', 'height: calc(100% - 24px);' );
		} else {
			iframeNode = getSslMessageElement( iframeContainer.id + '-iframe' );
		}
		spontanioTitle.insertAdjacentElement( 'afterend', iframeNode );
	}

	// remove opened iFrame form the page
	function removeIframe( id ) {
		switch ( id ) {
			case 'spontanio-widget-close':
				iframeContainer = document.querySelector( '#spontanio-widget' );
				break;
			case 'spontanio-block-close':
				iframeContainer = document.querySelector( '#spontanio-block' );
				break;
			case 'shortcode-block-close':
				iframeContainer = document.querySelector( '#spontanio-shortcode' );
				break;
			case 'spontanio-onload-close':
				iframeContainer = onloadContainer;
				break;
		}

		var iframeNode = document.querySelector( '#' + iframeContainer.id + '-iframe' );
		iframeContainer.removeChild( iframeNode );
		iframeContainer.style.display = 'none';
	}

	// create element for the message if site doesn't use SSL
	function getSslMessageElement( idValue ) {
		var messageNode = document.createElement( 'p' );
		messageNode.setAttribute( 'id', idValue );
		messageNode.setAttribute( 'class', 'spontanio-security-message' );
		messageNode.innerHTML = 'Sorry, but to protect your privacy, Spontanio can only be used on sites that use SSL. Please change the URL to begin with https://';
		return messageNode;
	}
});