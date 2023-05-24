<?php
$user 				  = get_user();
$user_id              = get_user()['id'];
$save_label           = null;

if ( ! $user_id ) {
	die();
} ?>

<div id="accordion-open" data-accordion="open">
<?php 
$questions_user = Database::get_user_questions($user_id);
echo '<ul role="list" class="divide-y divide-gray-100 dark:divide-gray-900">';
$i = 1;

foreach ($questions_user as $question) :
    $answer = Database::get_question_answer( $question['id'] );
	?> 

		<?php if ($i == 1) : ?>
		
		<h2 id="accordion-open-heading-<?php echo $i ?>">
			
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400" data-accordion-target="#accordion-open-body-<?php echo $i ?>" aria-expanded="false" aria-controls="accordion-open-body-<?php echo $i ?>">
			<h1 class="question-title w-200"> <?php echo $question['title']; ?> </h1>
            <p><?php echo Database::get_categorie_question($question['id']); ?></p>
            <p><?php echo $question['creation_date']; ?></p>
            <span class="flex items-center"><?php echo "<p>" . $question['number_likes'] . "</p>"; ?><img src="assets/images/like.png" alt="" class="like-png"></span>
            <p class="w-650"><?php echo $question['content']; ?></p>
			<svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
			</button>
		</h2>

        <div id="accordion-open-body-<?php echo $i ?>" class="hidden" aria-labelledby="accordion-open-heading-<?php echo $i ?>">
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


		<?php elseif($i != sizeof($questions_user)): ?>

		<h2 id="accordion-open-heading-<?php echo $i ?>">

			<button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-<?php echo $i ?>" aria-expanded="false" aria-controls="accordion-open-body-<?php echo $i ?>">
			<h1 class="question-title w-200"> <?php echo $question['title']; ?> </h1>
            <p><?php echo Database::get_categorie_question($question['id']);?></p>
            <p><?php echo $question['creation_date']; ?></p>
            <span class="flex items-center"><?php echo $question['number_likes']; ?><img src="assets/images/like.png" alt="" class="like-png"></span>
            <p class="w-650"><?php echo $question['content']; ?></p> 
			<svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
			</button>
		</h2>

        <div id="accordion-open-body-<?php echo $i ?>" class="hidden" aria-labelledby="accordion-open-heading-<?php echo $i ?>">
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

		<?php else: ?>
        <h2 id="accordion-open-heading-<?php echo $i ?>" class="border-gray-200">
			<button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-<?php echo $i ?>" aria-expanded="false" aria-controls="accordion-open-body-<?php echo $i ?>">
            <h1 class="question-title w-200"> <?php echo $question['title']; ?> </h1>
            <p><?php echo Database::get_categorie_question($question['id']); ?></p>
            <p><?php echo $question['creation_date']; ?></p>
            <span class="flex items-center"><?php echo $question['number_likes']; ?><img src="assets/images/like.png" alt="" class="like-png"></span>
            <p class="w-650"><?php echo $question['content']; ?></p>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </h2>
        <div id="accordion-open-body-<?php echo $i ?>" class="hidden" aria-labelledby="accordion-open-heading-<?php echo $i ?>">
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


		<?php endif; ?>

		
		
	<?php 
	$i++;
	?>
<?php endforeach; ?>
</div>