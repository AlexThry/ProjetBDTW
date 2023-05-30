<?php

require_once 'includes/header.php';

$is_admin        = get_user() ? get_user()['is_admin'] : false;
$question_id     = key_exists('id', $_GET) && !empty($_GET['id']) ? $_GET['id'] : null;
$add_question    = key_exists('new_question', $_GET) && !empty($_GET['new_question']);
$question_exists = Database::question_exists( $question_id );
$is_validated    = Database::question_is_validated( $question_id );
?>

<section class="flex pt-4 pb-8 lg:pt-8 lg:pb-12 bg-white dark:bg-gray-900">
	<div class="flex flex-col justify-between px-4 mx-auto max-w-screen-md flex-1">

		<?php
		// Check if `add question` form must be displayed
		if ( $add_question ) {
			require_once 'includes/new-question-form.php';
		// Check if question id is given
		} elseif ( $question_id === null ) {
			AlertManager::display_info( 'Aucune question n\'a été sélectionnée.' );
		// Check if question exists
		} elseif ( !$question_exists )  {
			AlertManager::display_warning( 'Cette question n\'existe pas' );
		// Check if question is validated (only an admin can see unvalidated questions)
		} elseif ( !$is_validated && !$is_admin ) {
			AlertManager::display_warning( 'Cette question n\'est pas visible pour le moment.' );
		// Display question
		} else {
			require_once 'includes/question.php';
			require_once 'includes/answer.php';
		}
		?>

	</div>
</section>

<?php

require_once 'includes/footer.php';
