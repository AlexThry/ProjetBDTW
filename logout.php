<?php
/**
 * Contains the logout form processing.
*/

require_once 'functions.php';

if ( get_user() ) $_SESSION['current_user'] = null;

header( 'Location: ' . get_home_url() );
exit();
