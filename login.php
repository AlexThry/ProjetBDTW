<?php
/**
 * Contains the connection form processing.
 */

require_once 'functions.php';

$user_name = isset($_POST['connection-user-name']) ? htmlentities($_POST['connection-user-name']) : null;
$password  = isset($_POST['connection-password']) ? htmlentities($_POST['connection-password']) : null;

if ( $user_name === null || $password === null ) {
	header("Location: connection.php");
}

$res = connect_user( $user_name, $password );

// This is painful, but we must keep the "=== true", because connect_user returns a bool or a non-empty string
header($res === true ? "Location: index.php" : "Location: connection.php?connection_error=$res");
exit;