<?php

require_once "functions.php";

$question_id = !empty($_GET['id']) ? $_GET['id'] : null;
$question = Question::get($question_id);
$add_question    = key_exists('new_question', $_GET);

if($question === null && !$add_question) {
    header("Location: index.php"); exit;
}

if( isset($_GET['liked']) && get_user() === null) {
    header("Location: connection.php"); exit;
}

require_once 'includes/header.php';

$is_admin        = get_user() !== null ? get_user()->is_admin() : false;
$is_validated    = $question !== null && $question->is_validated();
?>

<section class="flex pt-4 pb-8 lg:pt-8 lg:pb-12 bg-white dark:bg-gray-900">
	<div class="flex flex-col justify-between px-4 mx-auto max-w-screen-md flex-1">
		<?php
		// Check if `add question`form must be displayed
		if ( $add_question ) {
			require_once 'includes/new-question-form.php';
		// Check if question id is given
		} elseif ( !$is_validated && !$is_admin ) {
			AlertManager::display_warning( 'Cette question n\'est pas visible pour le moment.' );
		// Display question
		} else {
			?>
			<div class='flex flex-row'>
				<div class="flex-1">
					<?php
					require_once 'includes/question.php';
					require_once 'includes/answer.php';
					?>
				</div>
				<?php require_once 'includes/nearby-questions.php'; ?>
			</div>
			<?php
		}
		?>
	</div>
</section>

<?php
require_once 'includes/footer.php';
