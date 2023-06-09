<?php

$user = get_user();
if($user === null) {
    header("Location: connection.php"); exit;
}
$categories = Category::all();
$is_admin   = $user !== null && $user->is_admin();

// Form submission, aide :
// - c'est le html contenu dans l'input #html-input qui est envoyé au serveur (pas le markdown)
// - pour récup les questions, test si la clé 'checkbox-item-i' existe dans $_GET avec key_exist($key, $_GET) (en incrémentant i jusqu'a ce que la clé n'existe plus)

// important veille bien à utiliser htmlentities
// (et encore plus pour l'attribut content de la db comme ca peut contenir du html)

$title   = isset($_POST['question_title']) ? htmlentities($_POST['question_title']) : null;
$content = isset($_POST['html-input']) ? htmlentities($_POST['html-input']) : null;

if ( $title !== null && $content !== null) {
	$i = 0;
	$categories_ids = [];
	foreach ($_POST as $key => $value) {
		if (strpos($key, 'checkbox-item-') === 0) {
			$categories_ids[] = (int)htmlentities($value);
		}
	}
	if (strlen($title) > 50) {
		AlertManager::display_error("Le titre ne doit pas dépasser 50 caractères");
	} else {
        Question::add( $user->get_id(), $title, $content, $categories_ids);
        AlertManager::display_success('La question à été ajoutée avec succès !');
	 }
} 
?>



<?php if ($user === null): AlertManager::display_warning('Vous devez être connecté pour poser une question'); ?>
<?php else:  ?>
	<?php if ( $is_admin ) : AlertManager::display_info("Vous êtes connecté en tant qu'administrateur. Êtes-vous sur de vouloir poser une question ?"); endif ?>

    <form action="#" method="post" class="flex-1 mt-8">
        <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Poser une question</h2>
        <div class="markdown-editor-container grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
                <label for="question_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                <input type="text" name="question_title" id="question_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sujet ..." required="">
            </div>

            <!-- markdown editor -->
            <div class="sm:col-span-2">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea required data-preview-id="renderer" data-input-id="html-input" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ma question ..."></textarea>
            </div>
            <div class="sm:col-span-2">
                <div class="html-markdown-renderer block p-2.5 w-full text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500 mb-4" rows="8" placeholder="Your description here"></div>
                <input type="hidden" class="html-input" name="html-input">
            </div>

            <!-- categories input -->
            <div id="categories-renderer" class="sm:col-span-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg flex w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-white"></div>
            <div class="sm:col-span-2">
                <button id="dropdownCheckboxButton" data-dropdown-toggle="categories-dropdown" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium inline-flex items-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">Catégories <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>

                <div id="categories-dropdown" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-md dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                        <?php

                        $i = 0;
                        foreach ( $categories as $category ) {
                            $name = "checkbox-item-$i";
                            $category_id = $category->get_id();
                            $category_label = $category->get_label();
                            ?>
                                <li>
                                    <div class="flex items-center">
                                        <input id="<?= $name ?>" name="<?= $name ?>" type="checkbox" value="<?= $category_id ?>" data-cat-label='<?= $category_label ?>' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="<?= $name ?>" class="flex-1 ml-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-300"><?= $category_label ?></label>
                                    </div>
                                </li>
                            <?php
                            $i++;
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
            Soumettre la question
        </button>

        <div id="editor-container"></div>
    </form>
<?php endif; ?>
	


