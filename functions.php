<?php

require_once 'classes/Answerable.php';

/**
 * Format date to show number of mins/hours/days/months/days since the date.
 *
 * @param string $date_value Date to format.
 * @return string
 * @throws Exception if the date has an invalid format
 */
function format_date(string $date_value ): string {
	setlocale( LC_TIME, 'fr_FR.UTF-8' ); // Set the locale to French

	$date           = new DateTime( $date_value );
    return $date->format( 'j M, Y' );
}

/**
 * Displays a value field for html inputs
 * Only if the input is in $array ($_POST, $_GET, $_SESSION...)
 */
function display_input_value( $input, array $array ): void {
	if ( !empty($array[$input]) ) {
		echo "value='" . htmlentities($array[ $input ]) . "'";
	}
}

/**
 * Generates a random string of a given length.
 *
 * @param integer $length Length of the string to generate.
 * @return string Random string.
 */
function generate_random_string(int $length = 10 ): string
{
	return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
}

/**
 * Remove falsy values from an array.
 *
 * @param array $array Array to filter.
 * @return array Filtered array.
 */
function remove_falsy_values(array $array ): array {
	foreach ( $array as $key => $value ) {
		if ( ! $value ) {
			unset( $array[ $key ] );
		}
	}

	return $array;
}

/**
 * Get current url.
 *
 * @return string
 */
function get_url(): string {
	return "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

/**
 * Get home url.
 *
 * @return string
 */
function get_home_url(): string {
	return basename( 'index.php' );
}

/**
 * Check if current page is home page.
 *
 * @return boolean
 */
function is_home_page(): bool {
	return 	basename(explode('?', get_url())[0]) === 'ProjetBDTW';
}

/**
 * Get url basename.
 *
 * Example: http://localhost:8888/Proj631/inscription.php returns inscription
 *
 * @return string
 */
function get_url_basename(): string {
	$file_name = basename( get_url() ); // get the file name with extension.
	$extension = pathinfo( $file_name, PATHINFO_EXTENSION ); // get the file extension.
	return str_replace( '.' . $extension, '', $file_name ); // remove the extension to get the inscription part.
}

Answerable::start();
