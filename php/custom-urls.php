<?php

/**
 * Summary: php file which implements custom URL functionality
 */


//Custom machine index feature
add_action('parse_request', 'gmuw_custom_url_handler_machine_index');
function gmuw_custom_url_handler_machine_index() {

  //define pattern
  $pattern = "/^\/gmuw-machine-index/i";

  //does the server request uri match the pattern?
  if(preg_match($pattern, $_SERVER["REQUEST_URI"])==1) {

    //display custom content
    include( plugin_dir_path( __DIR__ ) . 'templates/machine-index.php' );
    exit();

  }

}
