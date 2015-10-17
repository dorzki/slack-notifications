<?php
/*
 * This is router for built-in php server. It is designed to use only for testing
 * This frees us from installing apache or nginx in travis
 * Usage: $ php -S 0.0.0.0:12000 router.php
 */

$root = $_SERVER['DOCUMENT_ROOT'];

$path = '/'. ltrim( parse_url( urldecode( $_SERVER['REQUEST_URI'] ) )['path'], '/' );

$requestfile = NULL;

// Search for request file
if(file_exists( $root.$path )) {
  $requestfile = $root.$path;
} else {
  // Check if wordpress core is installed in subdirectory by searching files in one subdirectory below
  // This makes it work with composer installed wordpress too
  foreach(scandir($root) as $file) {
    if($file == '.' || $file == '..') continue;
    $filename = '/'.$file.$path;
    if(file_exists( $root.$filename )) {

      // Check if assets are in subfolder
      if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg|min|ttf|swf|xml)$/', $_SERVER["SCRIPT_NAME"])) {
        // We can't rewrite assets but we can redirect them
        header("Location: $filename");
        exit();
      }
      $requestfile = $root.$filename;
      break;
    }
  }
}

// In testing environment use whatever we get as hostname
define('WP_HOME',    'http://'.$_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://'.$_SERVER['HTTP_HOST']);

// We can't use https in travis
define('FORCE_SSL_ADMIN', false);

if ( $requestfile ) {
  if ( is_dir( $requestfile ) && substr( $path, -1 ) !== '/' ) {
    header( "Location: $path/" );
    exit;
  }
  if ( strpos( $path, '.php' ) !== false ) {
    chdir( dirname( $requestfile ) );
    require_once basename($requestfile); // If file exists just use it!
  } elseif(is_dir($requestfile)) {
    chdir( dirname( $requestfile ) );
    require_once 'index.php'; // If this was a folder use index.php instead
  } else {
    return false; // This just means to return file as is
  }
} else {
  chdir( $root );
  require_once 'index.php';
}