<?php

/**
 * Check if password is secure enough.
 * To be secure, a password must:
 *  - contains at least 8 characters
 *  - contains at least 1 lowercase letter
 *  - contains at least 1 uppercase letter
 *  - contains at least 1 number
 *
 * @param string $password Password to check.
 * @return boolean
 */
function password_is_secure_enough(string $password ): bool {
	return preg_match( '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password );
}

/**
 * Check if mail valid.
 *
 * @param string $mail Mail to check.
 * @return boolean
 */
function valid_mail(string $mail ): bool {
	return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail);
}

/**
 * Check if first name or last name is valid.
 *
 * @param string $name name to check.
 * @return boolean
 */
function valid_name(string $name ): bool {
	return preg_match('/^[a-zA-ZÀ-ÖØ-öø-ſ]+([ \'-][a-zA-ZÀ-ÖØ-öø-ſ]+)*$/', $name);
}

/**
 * Attempts connection.
 *
 * @param string $username Username.
 * @param string $password Password.
 * @return true|void True if success, nothing otherwise.
 */
function connect_user(string $username, string $password ) {
	global $conn;

	// Validate inputs.
	$errors = array();
	if ( empty( $username ) )  $errors[] = "Insérez votre nom d'utilisateur.";
    else $_SESSION['previous_values']['username'] = $username;
	if ( empty( $password ) )  $errors[] = "Insérez votre mot de passe.";
	if ( ! empty( $errors ) ) {
        $_SESSION['subscription_errors'] = $errors; return;
	}

	// Protect from XSS attack.
	$query = sprintf(
		"SELECT * FROM user WHERE user_name='%s' LIMIT 1",
		$conn->real_escape_string( $username )
	);

	$result = $conn->query( $query );

	$result = mysqli_fetch_assoc( $result );
	if ( ! $result ) {
        $_SESSION["subscription_errors"] = ["Ce compte n'existe pas."]; return;
	}

	$hash_password = md5( $password );
	if ( $result['password'] !== $hash_password ) {
        $_SESSION["subscription_errors"] = ["Mot de passe incorrect."]; return;
	}

	add_user_to_session($result);

	return true;
}

/**
 * Adds a user to the session, using the result of a query.
 *
 * @param array $result The row of a database query (must represent a user)
 * @return void
 */
function add_user_to_session( array $result ): void {
	$_SESSION['current_user'] = User::from_sql($result);
}
/**
 * Attempts subscription.
 *
 * @param string $username Username.
 * @param string $password Password.
 * @param string $confirm_password Confirm password.
 * @param string $first_name First name.
 * @param string $last_name Last name.
 * @param string $mail Mail.
 *
 * @return true|void True if subscription was successful, void otherwise.
 */
function subscribe_user(string $username, string $password, string $confirm_password, string $first_name, string $last_name, string $mail ) {
	global $conn;

	// Validate inputs.
	$errors = array();
	if ( empty($username) ) $errors[] = "Insérez votre nom d'utilisateur";
    else $_SESSION['previous_values']['username'] = $username;
	if ( empty($password) ) $errors[] = 'Insérez votre mot de passe';
	if ( !empty($password) && empty( $confirm_password ) ) $errors[] = 'Confirmez votre mot de passe';
	if ( !empty($mail) && ! valid_mail($mail)) $errors[] = "Le mail est incorrect.";
    else $_SESSION['previous_values']['mail'] = $mail;
	if ( !empty($last_name) && ! valid_name($last_name)) $errors[] = "Le nom ne peut pas contenir de chiffre ou de caractère spécial.";
    else $_SESSION['previous_values']['last_name'] = $last_name;
	if ( !empty($first_name) && ! valid_name($first_name)) $errors[] = "Le prénom ne peut pas contenir de chiffre ou de caractère spécial.";
    else $_SESSION['previous_values']['first_name'] = $first_name;

	if ( !empty( $errors ) ) {
        $_SESSION['subscription_errors'] = $errors; return;
    }

    if ( ! password_is_secure_enough( $password ) ) $errors[] = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.';
	if ( $password !== $confirm_password ) $errors[] = 'Les mots de passe ne correspondent pas.';

    if ( ! empty( $errors ) ) {
        $_SESSION['subscription_errors'] = $errors; return;
    }

	// Check if user already exists
	$res = $conn->query("SELECT id FROM user WHERE user.user_name = \"$username\" LIMIT 1");
	if(mysqli_num_rows($res)) {
        $_SESSION['subscription_errors'] = ['Ce compte existe déjà. Changez votre nom d\'utilisateur']; return;
    }

	$date          = date( 'Y-m-d' );
	$hash_password = md5( $password );
	$sql           = "INSERT INTO user (user_name, password, creation_date, first_name, last_name, email)
		VALUES ('" . $username . "','" . $hash_password . "','" . $date . "','" . $first_name . "','" . $last_name . "','" . $mail . "')";

	// Launch query
	$res = $conn->query($sql);
	if(!$res) {
        $_SESSION['subscription_errors'] = ['Erreur lors de l\'inscription.'];
        return;
    }

	// Get newly created user
	$res = mysqli_fetch_assoc($conn->query("SELECT * FROM user WHERE id = LAST_INSERT_ID()"));

	// Connect user
	add_user_to_session($res);

	return true;
}
