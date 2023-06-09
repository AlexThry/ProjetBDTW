<?php

require_once 'includes/header.php';

$category_label = !empty( $_GET['category']) ? $_GET['category'] : null;
$search_string  = !empty( $_GET['search']) ? $_GET['search'] : null;
$is_search      = $category_label !== null || $search_string !== null;
?>

<div class="content">
    <?php if($is_admin && empty( $_GET )) : ?>
        <?php require_once 'includes/admin-dashboard.php' ?>
    <?php else : ?>
        <section class="relative bg-white dark:bg-gray-800">
            <div class="pb-80 pt-4 sm:pb-40 sm:pt-6 lg:pb-48 lg:pt-10">
                <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
                    <?php if ( !$is_search ) : ?>

                        <div class="grid px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-2">
                            <div class="sm:max-w-lg mt-10">
                                <h1 class="font text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Ne laissez aucune question sans réponse</h1>
                                <p class="mt-4 text-xl text-gray-500 dark:text-gray-300">Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions sur le cours sur notre site interactif et bénéficiez des réponses de nos experts!</p>
                                <hr class="mt-10 opacity-0">
                                <?php require 'includes/search-bar.php'; ?>
                            </div>
                            <div class="w-full flex">
                                <img class="w-full flex-1 dark-theme h-8 w-auto" style="height:500px;" src="./assets/images/programming-dark.svg" alt="Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions">
                                <img class="w-full flex-1 light-theme h-8 w-auto" style="height:500px;" src="./assets/images/programming-light.svg" alt="Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions">
                            </div>
                        </div>
                        
                    <?php endif; ?>
                    <div class="mt-10">
                        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                            <div class="mt-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">Titre</th>
                                                <th scope="col" class="px-4 py-3">Catégories</th>
                                                <th scope="col" class="px-4 py-3">Date</th>
                                                <th scope="col" class="px-4 py-3">Utilisateur</th>
                                                <th scope="col" class="px-4 py-3 text-center">Nombre de likes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $questions = Question::search_full($category_label, $search_string);
                                            foreach ($questions as $question) :
                                                $question_id = $question->get_id();
                                                $url = "single-question.php?id=$question_id";
                                            ?>
                                                <tr class="border-b dark:border-gray-700">
                                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <a href="<?= $url ?>">
                                                            <?= $question->get_title() ?>
                                                        </a>
                                                    </th>
                                                    <td class="px-4 py-3">
                                                        <span class="flex py-1">
                                                        <?php Component::display_categories($question->get_categories()) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3"><?= format_date($question->get_creation_date()) ?> </td>
                                                    <td class="px-4 py-3"><?= $question->get_username() ?></td>
                                                    <td class="px-4 py-3 text-center"><?= $question->get_likes() ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php
require_once 'includes/footer.php';
