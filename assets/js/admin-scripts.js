jQuery( document ).ready( function( $ ) {

  // Display the media upload screen on click.
  $( '#slack_bot_image_button' ).on( 'click', function() {

    tb_show( 'Upload a logo', 'media-upload.php?referer=custom_branding&type=image&TB_iframe=true&post_id=0', false  );

    return false;

  } );



  if( location.search.indexOf( 'slack_notifications' ) !== -1 ) {

    // Assign the uploaded file url to the input.
    window.send_to_editor = function( html ) {

      var botImage = $( 'img', html );

      $( '#slack_bot_image' ).val( botImage.attr( 'src' ) );
      $( '#slack_bot_image_preview' ).html( botImage );

      tb_remove();

    }

  }



  // Dismiss the admin notices.
  $( document ).on( 'click', '.dorzki-slack-notice .notice-dismiss', function() {

    $.ajax( {
      url: ajaxurl,
      data: {
        action: 'dorzki-slack-dismiss-notice'
      }
    } );

  } );



  // Test notification.
  $( '#dorzki-test-integration' ).on( 'click', function() {

    $( this ).prop( 'disabled', true );
    $( '#test-spinner' ).show();

    $.ajax( {
      url: ajaxurl,
      dataType: 'json',
      data: {
        action: 'dorzki-slack-test-integration'
      },
      success: function( data ) {

        $( '#test-spinner' ).hide();

        if( data.success ) {
          $( '#dorzki-test-integration' ).after( '<span class="dashicons dashicons-yes test-success"></span>' );
        } else {
          $( '#dorzki-test-integration' ).after( '<span class="dashicons dashicons-no-alt test-fail"></span>' );
        }

      }
    } )

  } );

} );