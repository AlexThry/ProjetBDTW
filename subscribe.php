<?php
/**
 * Contains the subscription form processing.
 */

require_once 'functions.php';

$username         = $_POST['subscription-user_name'] ?? null;
$password         = $_POST['subscription-password'] ?? null;
$confirm_password = $_POST['subscription-confirm-password'] ?? null;
$mail             = $_POST['subscription-mail'] ?? null;
$first_name       = $_POST['subscription-first_name'] ?? null;
$last_name        = $_POST['subscription-last_name'] ?? null;

$res = subscribe_user( $username, $password, $confirm_password, $first_name, $last_name, $mail);
if ( $res === true ) header( 'Location: account.php' );
else header( 'Location: subscription.php' );
exit;
