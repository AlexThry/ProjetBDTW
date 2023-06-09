<?php

/**
 * Returns the current user or false if there's none.
 *
 * @return null|User
 */
function get_user(): ?User
{
	if ( ! isset( $_SESSION['current_user'] ) ) return null;
	return $_SESSION['current_user'];
}

/**
 * Refresh the current user.
 *
 * @throws Exception If the user is not found.
 *
 * @return void
 */
function refresh_user(): void {
	$session_user = get_user();
	if ( $session_user === null ) return;

	$id   = $session_user->get_id();
	$user = User::get( $id );

	if ( ! $user ) throw new Exception( 'User not found' );

	$_SESSION['current_user'] = $user;
}
