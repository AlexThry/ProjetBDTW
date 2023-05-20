<?php

require_once 'includes/header.php';

$user = get_user();

?>

<section class="flex pt-4 pb-8 lg:pt-8 lg:pb-12 bg-white dark:bg-gray-900">
	<div class="flex justify-between px-4 mx-auto max-w-screen-md flex-1">

		<?php

		if ( key_exists( 'new_question', $_GET ) ) {
			require_once 'includes/new-question-form.php';
		} elseif ( key_exists( 'id', $_GET ) ) {
			$id       = htmlentities( $_GET['id'] );
			$question = Database::get_question_by_id( $id );
			$answers  = Database::get_answer_by_question_id( $id );
		} else {
			AlertManager::display_info( 'Aucune question n\'a été sélectionnée' );
		}

		?>

	</div>
</section>

<?php

require_once 'includes/footer.php';
