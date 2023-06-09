<?php
// Check if user is connected as admin
if( !$is_admin ) {
    header("Location: admin.php");
    exit();
}

$selected_tab = $_GET['tab'] ?? null;
?>

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
        <ul class="space-y-2">
            <li>
                <a href="index.php" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
                <span class="ml-3">Vue d'ensemble</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" >
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap">Questions</span>
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                </button>
                <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                <li>
                    <a href="?tab=all-questions" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Toutes</a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">A répondre</a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">A valider</a>
                </li>
                </ul>
            </li>
        </ul>
        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
          <li>
            <a href="#" class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
              <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
              </svg>
              <span class="ml-3">Brouillons</span>
            </a>
          </li>
        </ul>
    </div>
</aside>

<section class="p-4 md:ml-64 h-auto pt-40">
    <?php if ($selected_tab === "all-questions") : ?>
        <h1 class="mb-20 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Toutes les questions</h1>
        <?php
            $questions = Question::all();
            Component::display_questions($questions, "without-empty-msg");
            if(empty($questions)) {
                ?>
                <p class="text-base font-medium text-gray-900 dark:text-white">Aucune questions à afficher</p>
                <?php
            }
        ?>


    <?php else : ?>
        <h1 class="mb-20 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Tableau de bord</h1>

        <!-- Displays unvalidated questions -->
        <h2 class="mt-4 mb-4 text-xl font-bold text-gray-900 dark:text-white">Questions non validées</h2>
        <?php
            $unvalidated_questions = Question::search("unvalidated","with-categories");
            Component::display_questions($unvalidated_questions, "validatable", "without-empty-msg");
            if(empty($unvalidated_questions)) {
                ?>
                <p class="text-base font-medium text-gray-900 dark:text-white">Plus de questions ici, votre travail est terminé !</p>
                <?php
            }
        ?>

        <!-- Displays unanswered questions -->
        <h2 class="mt-20 mb-4 text-xl font-bold text-gray-900 dark:text-white">Questions sans réponse</h2>
        <?php
            $unanswered_questions = Question::search("unanswered","with-categories","with-likes");
            Component::display_questions($unanswered_questions, "answerable", "with-likes");
        ?>


        <!-- Add a category -->
        <section class="mt-20 bg-white dark:bg-gray-800 ml-">
            <div class="py-4 ml-2">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Ajouter une nouvelle catégorie</h2>
                <form action="add-category.php" method="post">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de la catégorie</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez un nom de catégorie" required="">
                        </div>


                    </div>
                    <button type="submit" name="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-4">Ajouter</button>
                </form>
            </div>
        </section>

        <!-- Suppress a category -->
        <h2 class="mb-4 mt-20    text-xl font-bold text-gray-900 dark:text-white">Supprimer une catégorie</h2>
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Sélectionner une catégorie<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>

        <form action="suppress-category.php" method="post">
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <?php
                    $categories = Category::all();
                    foreach ( $categories as $category ) :
                    ?>
                        <li data-cat="<?= $category->get_label() ?>">
                            <button data-modal-target="category-modal-<?= $category->get_id() ?>" data-modal-toggle="category-modal-<?= $category->get_id() ?>" type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" >
                                <?= html_entity_decode($category->get_label()); ?>
                            </button>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>

            <?php foreach ( $categories as $category ) :
                $id = $category->get_id();
                $nb_questions = $category->nb_questions();
            ?>
            <div id="category-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Suppression</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="category-modal-<?= $id ?>">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Fermer</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-6">
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">Vous vous apprêtez à supprimer une catégorie. Cela affectera <?= $nb_questions ?> questions. Une fois supprimée, vous ne pourrez plus revenir en arrière.</p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">Êtes-vous sûr de vouloir supprimer "<?= $category->get_label() ?>" ?</p>
                        </div>
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" name="id" value=<?= $id ?> class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Supprimer</button>
                            <button data-modal-hide="category-modal-<?= $id ?>" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </form>
    <?php endif; ?>
</section>
