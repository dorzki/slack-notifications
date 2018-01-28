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

})( jQuery );