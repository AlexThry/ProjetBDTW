<?php
global $question;
/**
 * Display an answer and edit buttons if user is admin.
 */

$id_question = isset($_GET['id']) ? (int)htmlentities($_GET['id']) : null;

// Check if question exists
if ( $id_question === null ) {
    header("Location: index.php");
	exit;
}

// Check if answer exists
$answer = $question->get_answer();
if($answer === null ) AlertManager::display_warning( "Cette question n'a pas encore de réponse" );
else {
    $answer_content = isset($_POST['answer-content']) ? htmlentities($_POST['answer-content']) : null;
    if ($answer_content !== null) {
        $answer->update($answer_content);
        AlertManager::display_success('La réponse à été modifiée avec succès !');
    }

    $answer_user = $answer->get_admin();
    $user = get_user();
    $is_admin = $user !== null && $user->is_admin();

    if ( key_exists( 'edit_answer', $_GET ) ) {
        if(!$is_admin) {
            AlertManager::display_warning( "T'es un petit malin toi ;). Désolé tu n'as pas le droit de modifier cette question." );
        } else {
            ?>
            <div class="markdown-editor-container text-gray-1000 rounded-b-lg">
                <form action="?id=<?= $id_question ?>" method="post" class="flex-1">
                    <div class="sm:col-span-2">
                        <textarea id="answer-editor" name="answer-content" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ma réponse ...">
                            <?= $answer->get_content() ?>
                        </textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <div class="html-markdown-renderer block p-2.5 w-full text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500" rows="8"></div>
                        <input type="hidden" class="html-input" name="html-input">
                    </div>
                    <input type="submit" value="valider" class="rounded-md bg-indigo-600 mb-4 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">
                </form>
            </div>
            <?php
        }
    } else {
        $admin_image = $answer_user->has_profile_url() ? $answer_user->get_profile_url() : "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80";
        ?>
        <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900 border border-gray-200 rounded-lg dark:border-gray-700">
            <footer class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"><img
                        class="mr-2 w-6 h-6 rounded-full"
                        src="<?= $admin_image ?>"
                        alt="<?= $answer_user->full_name() ?>"><?= $answer_user->full_name() ?></p>
                </div>

                <?php if ( $is_admin ) : ?>
                    <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        type="button">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                            </path>
                        </svg>
                        <span class="sr-only">Options</span>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownComment1"
                        class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconHorizontalButton">
                            <li>
                                <a href="?id=<?= htmlentities( $id_question ); ?>&edit_answer=true"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </footer>
            <mark class="text-gray-800 dark:text-gray-200 html-markdown-renderer flex-1">
                <?php if ( $answer !== null ) echo html_entity_decode( $answer->get_content() ) ?>
            </mark>

            <!-- Pour aller plus loin. Ajouter bouton répondre -->
            <!-- <div class="flex items-center mt-4 space-x-4">
                <button type="button"
                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                    <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Répondre
                </button>
            </div> -->
        </article>
        <?php
    }
}


