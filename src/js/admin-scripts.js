(function ( $ ) {

	var media_frame;

	// Handle media fields.
	$( '.preview_image_box' ).on( 'click', function ( e ) {
		e.preventDefault();

		var _preview = $( this );
		var _input = _preview.next( 'input' );

		if ( !media_frame ) {

			media_frame = wp.media( {
				title: sn_lang.media_frame_title,
				button: {
					text: sn_lang.media_frame_button
				},
				multiple: false
			} )

		}

		media_frame.on( 'select', function () {

			var _image = media_frame.state().get( 'selection' ).first().toJSON();

			_input.val( _image.url );
			_preview.addClass( 'has_image' ).find( 'img' ).attr( 'src', _image.url );

		} );

		media_frame.open();

	} );

	// Remove media image
	$( '.preview_image_box .remove-image' ).on( 'click', function ( e ) {
		e.stopPropagation();
		e.preventDefault();

		var _preview = $( this ).parents( '.preview_image_box' );

		_preview.removeClass( 'has_image' );
		_preview.next( 'input' ).val( null );

	} );

	// Handle integration test notification.
	$( '.slack_test_integration' ).on( 'click', function ( e ) {
		e.preventDefault();

		var _btn = $( this );
		var _input = _btn.next( 'input' );

		_btn.removeClass( 'testing ok error' ).addClass( 'testing' );

		$.ajax( {
			url: ajaxurl,
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'slack-test-integration'
			},
			success: function ( response ) {

				_btn.removeClass( 'testing ok error' );

				if ( response.success ) {

					_btn.addClass( 'ok' );
					_input.val( '1' );

				} else {

					_btn.addClass( 'error' );
					_input.val( '0' );

				}

			}
		} );

	} );

	// Handle new notification button link
	$( 'a.page-title-action[href="#new_notification"]' ).on( 'click', function ( e ) {
		e.preventDefault();

		var _box = $( '#notification_box' ).html();

		$( _box ).clone().appendTo( '.notifications-wrapper' );

	} );

	// Handle notifications collapsible action.
	$( document ).on( 'click', '.notification-box .notification-header', function ( e ) {
		e.preventDefault();

		$( this ).next( '.notification-settings' ).slideToggle();
		$( this ).parent( '.notification-box' ).toggleClass( 'open' );

	} );

	// Handle notification type switch
	$( document ).on( 'change', '.notification-box select', function () {

		var _title = '';
		var _notif = $( this ).parents( '.notification-box' );
		var _type = _notif.find( 'select.notification-type' );

		if ( $( this ).hasClass( 'notification-type' ) ) {

			_notif.find( 'select.notification_options' ).removeClass( 'current' ).hide();
			_notif.find( 'select[name="notification[action][' + _type.val() + '][]"]' ).addClass( 'current' ).show();

		}

		var _action = _notif.find( 'select[name="notification[action][' + _type.val() + '][]"]' );

		_title = _type.find( 'option[value="' + _type.val() + '"]' ).text();
		_title = '[' + _title + '] ' + _action.find( 'option[value="' + _action.val() + '"]' ).text();

		_notif.find( 'h2' ).text( _title );
		_notif.find( 'input[name="notification[title][]"]' ).val( _title );

	} );

	// Handle notification removal button
	$( document ).on( 'click', '.remove-notification', function ( e ) {
		e.preventDefault();

		$( this ).parents( '.notification-box' ).remove();

	} );

	// Copy report data to clipboard.
	$( '.copy-report' ).on( 'click', function ( e ) {
		e.preventDefault();

		$( '#slack_tech_data' ).select();

		document.execCommand( 'copy' );

	} );

})( jQuery );