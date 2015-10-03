jQuery( document ).ready( function( $ ) {

  // Display the media upload screen on click.
  $( '#slack_bot_image_button' ).on( 'click', function() {

    tb_show( 'Upload a logo', 'media-upload.php?referer=custom_branding&type=image&TB_iframe=true&post_id=0', false  );

    return false;

  } );



  // Assign the uploaded file url to the input.
  window.send_to_editor = function( html ) {

    var botImage = $( 'img', html );

    $( '#slack_bot_image' ).val( botImage.attr( 'src' ) );
    $( '#slack_bot_image_preview' ).html( botImage );

    tb_remove();

  }

} );