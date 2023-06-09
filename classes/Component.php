<?php

/**
 * Class that manages component creation
 */
final class Component {
    // Static variables used display the correct category label color
    // See `display_question`
    public static $default_category_color = "blue";
    public static $category_to_color = [
        "GIT"        => "pink",
        "JAVASCRIPT" => "yellow",
        "HTML"       => "red",
        "CSS"        => "blue",
        "PHP"        => "indigo",
        "BD"         => "green",
    ];

    public static function get_category_color( $label ): string
    {
        if(! key_exists(strtoupper($label), self::$category_to_color)) {
            return self::$default_category_color;
        }
        return self::$category_to_color[$label];
    }


    /**
     * Displays a question
     *
     * @param Question $question Question to display
     * @param array $options Display options, will change the way the question is displayed
     * @return void
     */
    private static function display_question(Question $question, array $options ) {
        $question_id = $question->get_id();
        $is_validated = $question->is_validated();

        // If question is answerable, change i_question value
        $answerable  = in_array("answerable", $options);
        $i_question  = key_exists("i-question", $options) && $answerable ? $options['i-question'] : 0;
        $with_likes  = in_array("with-likes", $options);
        $validatable = in_array("validatable", $options) && !$answerable;
        ?>

        <h2 id="accordion-open-heading-<?= $i_question ?>">
            <div class="rounded-t-lg flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false">
                <a href="single-question.php?id=<?= $question_id ?>"><h1 class="question-title w-200"><?= html_entity_decode($question->get_title()) ?></h1></a>
                <?php self::display_categories($question->get_categories()) ?>

                <?php if($with_likes && $is_validated) : ?>
                    <span class="flex items-center"><?= $question->get_likes() ?><img src="assets/images/like.png" alt="" class="like-png"></span>
                <?php endif; ?>

                <?php if(!$is_validated) : ?>
                    <span class="flex items-center">Non validée</span>
                <?php endif; ?>



                <p><?= format_date($question->get_creation_date()) ?></p>

                <?php if($validatable) : ?>
                    <div class="flex gap-4">
                        <a href="<?= "single-question.php?id=$question_id&edit=true" ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5 mr-2 -ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                            </svg>
                            Editer
                        </a>

                        <a href="<?= "validate-question.php?question-id=$question_id" ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5 mr-2 -ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Valider
                        </a>
                    </div>
                <?php endif; ?>

                <?php if($answerable) : ?>
                    <button type="button" data-accordion-target="#accordion-open-body-<?= $i_question ?>" aria-expanded="false" aria-controls="accordion-open-body-<?= $i_question ?>" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Répondre
                    </button>
                <?php endif; ?>
            </div>
        </h2>

        <div class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false">
            <mark class="text-gray-800 dark:text-gray-200 html-markdown-renderer flex-1">
                <?= html_entity_decode($question->get_content()) ?>
            </mark>
        </div>

        <?php if($answerable) : ?>
            <div id="accordion-open-body-<?= $i_question ?>" class="hidden" aria-labelledby="accordion-open-heading-<?= $i_question ?>">
                <div class="markdown-editor-container border border-gray-200 text-gray-1000 dark:text-gray-100 dark:border-gray-700 rounded-b-lg">
                    <form action="add-answer.php" method="post" class="flex-1">
                        <input type="hidden" name="id-question" value=<?= $question_id ?>>
                        <div class="sm:col-span-2">
                            <textarea required rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ma réponse ..."></textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="html-markdown-renderer block p-2.5 w-full text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500" rows="8"></div>
                            <input type="hidden" class="html-input" name="html-input">
                        </div>
                        <button type="submit" class="mx-2 my-2 inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                            Enregistrer cette réponse
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        <?php
    }

    /**
     * Displays a list of categories
     * @param array $categories
     */
    public static function display_categories( array $categories ) {
        echo '<div class="flex align-center">';
        foreach ($categories as $category) :
            $category_label = $category->get_label();
            $url = "?category=$category_label";
            $color = self::get_category_color($category_label);
            ?>
                <div class="flex flex-wrap">
                    <a class="bg-<?= $color ?>-100 text-<?= $color ?>-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-<?= $color ?>-200 hover:bg-<?= $color ?>-200 dark:hover:bg-<?= $color ?>-300 dark:text-<?= $color ?>-800"
                    href="<?= $url ?>"> <?= $category_label ?>
                    </a>
                </div>
            <?php
        endforeach;
        echo '</div>';
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
        // Special display if the question is answerable
        $answerable = in_array("answerable", $options);
        // Check if component should display the "Aucune questions" message
        $display_empty_msg = empty($questions) && !in_array("without-empty-msg", $options);
        // Answerable questions need a counter to be "opened" correctly
        $i_question = 0;

        if ( $questions ) : ?>
            <div id="accordion-open" data-accordion="open">
                <ul role="list">
                    <?php
                    foreach ($questions as $question) {
                        echo "<li class='mb-7'>";
                        if($answerable) {
                            $options['i-question'] = $i_question;
                            $i_question++;
                        }
                        self::display_question( $question, $options );
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>

        <?php elseif($display_empty_msg) : ?>

            <div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
                <h2 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Aucune questions !</h2>
                <p class="mb-4 text-lg text-gray-600 dark:text-gray-400">
                    Pour poser une question, c'est par
                    <a href='single-question.php?new_question' class="dark:text-white">ici</a>
                </p>
            </div>

        <?php endif;
    }
}