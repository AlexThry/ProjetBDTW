<?php

if ( ! class_exists( 'Component' ) ) {

	/**
	 * Class that manages component creation
	 */
	final class Component {

		/**
		 * Displays a question
		 *
		 * @param array $question Question to display
		 * @param array $options Display options, will change the way the question is displayed
		 * @return void
		 */
		public static function display_question( $question, ...$options ) {
			$question_id    = $question['id'];
			$categories     = Database::get_question_categories($question_id);
            $first_category = empty($categories) ? "Aucune" : $categories[0]['label'];

			// Getting individual display options
			$with_validation_action  = in_array("with-validation-action", $options[0]);
			$with_answer_action      = in_array("with-answer-action", $options[0]);
			if($with_validation_action) $validation_url = "validate-question.php?question-id=$question_id&previous-url=$_SERVER[REQUEST_URI]";
			// TODO : Write url to write answer
			if($with_answer_action)     $answer_url     = "#";
			?>

			<h2 id="accordion-open-heading">
				<div class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false">
					<h1 class="question-title w-200"> <?php echo $question['title'] ?> </h1>
					<p><?php echo $first_category ?></p>
					<p><?php echo $question['creation_date'] ?></p>
					<p class="w-650"><?php echo $question['content'] ?></p>

					<?php if($with_validation_action) : ?>
						<a href="<?php echo $with_validation_action ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
							<svg fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5 mr-2 -ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							Validé
						</a>
					<?php endif; ?>

					<?php if($with_answer_action) : ?>
						<a href="<?php echo $answer_url ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Répondre</a>
					<?php endif; ?>
				</div>
			</h2>
			<?php
		}


		/**
		 * Displays a grid of questions
		 * If theres no question, displays a message.
		 *
		 * @param array $questions Questions.
		 * @param array $options Other passed arguments, that will be interpreted as display options (see display_question)
		 * @return void
		 */
		public static function display_questions( $questions, ...$options ): void {
			if ( $questions ) : ?>
				<div id="accordion-open" data-accordion="open">
					<ul role="list" class="divide-y divide-gray-100 dark:divide-gray-900">
						<?php
						foreach ($questions as $question) {
							self::display_question( $question, $options );
						}
						?>
					</ul>
				</div>
			<?php else : ?>
				<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
					<h2 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white" id="content">Aucune questions !</h2>
					<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">
						Pour poser une question, c'est par
						<a href='<?php echo get_home_url() ?>' class="dark:text-white">ici</a>
					</p>
				</div>
			<?php endif;
		}

		/**
		 * Displays a list of questions
		 * If theres no question, displays a message.
		 *
		 * @param array $questions Questions.
		 * @return void
		 */
		public static function display_user_question( $questions_user ): void { 
			$i_question = 0; ?>
			<div id="accordion-open" data-accordion="open">
				<ul role="list" class="divide-y divide-gray-100 dark:divide-gray-900">
					<?php
					foreach ($questions_user as $question) :
						$answer         = Database::get_question_answer( $question['id'] );
						$categories     = Database::get_question_categories( $question['id'] );
						$first_category = empty($categories) ? "Aucune" : $categories[0]['label'];
						// The following boolean are used to make custom display for each accordion questions
						$is_first_question  = $i_question === 0;
						$is_last_question   = $i_question === sizeof($questions_user) - 1;
						$is_middle_question = !$is_first_question && !$is_last_question;
					?>

						<h2 id="accordion-open-heading-<?php echo $i_question ?>" <?php if($is_middle_question) echo "class='border-gray-200'" ?>>
							<button type="button"
								class="
								<?php
									if($is_first_question)    echo 'flex items-center justify-between w-full p-5 font-medium text-left border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400';
									elseif($is_last_question) echo 'flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800';
									else                      echo 'flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800';
								?>"
								data-accordion-target="#accordion-open-body-<?php echo $i_question ?>" aria-expanded="false" aria-controls="accordion-open-body-<?php echo $i_question ?>"
							>
								<h1 class="question-title w-150"> <?php echo $question['title'] ?> </h1>
								<p class="w-20 text-center"><?php echo $first_category ?></p>
								<p class="w-100 text-center"><?php echo $question['creation_date'] ?></p>
								<span class="flex items-center"><?php echo $question['number_likes'] ?><img src="assets/images/like.png" alt="" class="like-png"></span>
								<p class="w-500"><?php echo $question['content'] ?></p>
								<svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
							</button>
						</h2>

						<div id="accordion-open-body-<?php echo $i_question ?>" class="hidden" aria-labelledby="accordion-open-heading-<?php echo $i_question ?>">
							<div class="border px-2 py-2 border-gray-200 text-gray-1000 dark:text-gray-100 dark:border-gray-700">
								<?php
									if ($answer) {
										echo "<div class='flex'>";
											$answer_user_id = $answer['id_user'];
											$admin_answer = Database::get_user($answer_user_id);
											echo "<div class='admin'><p>" . $admin_answer['user_name'] . "</p></div>";
											echo "<div class='admin-answer'><p>" . $answer['content'] . "</p>";
											echo "<p>" . $answer['raw_html'] . "</p></div>";
										echo "</div>";
									} else {
										echo "<p>Pas de réponse, veuillez patienter...</p>";
									}
								?>
							</div>
						</div>
					<?php $i_question++; ?>
				<?php endforeach; ?>
			</div>
		<?php }
	}
}?>