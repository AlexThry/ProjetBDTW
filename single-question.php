<?php

require_once 'includes/header.php';

$user = get_user();

?>

<section class="flex pt-4 pb-8 lg:pt-8 lg:pb-12 bg-white dark:bg-gray-900">
	<div class="flex flex-col justify-between px-4 mx-auto max-w-screen-md flex-1">

		<?php

		if ( key_exists( 'new_question', $_GET ) ) {
			require_once 'includes/new-question-form.php';
		} elseif ( key_exists( 'id', $_GET ) ) {
			require_once 'includes/question.php';
			require_once 'includes/answer.php';
		} else {
			AlertManager::display_info( 'Aucune question n\'a été sélectionnée' );
		}

		?>

	</div>
</section>

<?php

require_once 'includes/footer.php';
