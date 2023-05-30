<?php require_once 'includes/header.php'; ?>

<div class="content">
    <?php if($is_admin && empty( $_GET )) : ?>
        <?php require_once 'includes/admin-dashboard.php' ?>
    <?php else : ?>
        <section class="relative bg-white dark:bg-gray-800">
            <?php if (empty($_GET)) : ?>
                <div class="pb-80 pt-16 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
                    <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
                    <div class="sm:max-w-lg">
                        <h1 class="font text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Ne laissez aucune question sans réponse</h1>
                        <p class="mt-4 text-xl text-gray-500 dark:text-gray-300">Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions sur le cours sur notre site interactif et bénéficiez des réponses de nos experts!</p>
                    </div>
                    <div>
                        <div class="mt-10">
                            <!-- Decorative image grid -->
                            <div aria-hidden="true" class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                                <div class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                                    <div class="flex items-center space-x-6 lg:space-x-8">
                                        <div class="rounded-lg sm:opacity-0 lg:opacity-100">
                                            <!-- <img src="https://img.freepik.com/vecteurs-libre/autogestion-coaching-vie-homme-doutant-interrogeant-brainstorming-crise-identite-delire-confusion-mentale-concept-sentiments-confus_335657-686.jpg?w=2000&t=st=1684596403~exp=1684597003~hmac=eff7995b8ee7c1020b09f53b595d887d3b5f805ee5e40becde09b084b06045c8" alt="" class="h-full w-full object-cover object-center">-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <a href="#" class="inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-center font-medium text-white hover:bg-indigo-700">Shop Collection</a> -->

                            <?php require 'includes/search-bar.php'; ?>

                            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                                <!-- Start coding here -->
                                <div class="mt-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-4 py-3">Titre</th>
                                                    <th scope="col" class="px-4 py-3">Catégorie</th>
                                                    <th scope="col" class="px-4 py-3">Date</th>
                                                    <th scope="col" class="px-4 py-3">utilisateur</th>
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php

                                            $questions = Database::get_questions();

                                            foreach ($questions as $question) {
                                                $categories = Database::get_categories_by_question_id($question['id']);
                                                $user = Database::get_user($question['id_user']);
                                                echo '
                                                    <tr class="border-b dark:border-gray-700">
                                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"><a href="single-question.php?id='.$question["id"].'" class="ml-2 text-sm font-medium text-blue-600 md:ml-2 dark:text-blue-500 hover:underline">'.$question["title"].'</a></th>
                                                        <td class="px-4 py-3" style="  transform: translateY(20%);">';
                                                        echo Component::display_categories($question['id']);

                                                    echo '</td>
                                                        <td class="px-4 py-3">'.format_date($question["creation_date"]).'</td>
                                                        <td class="px-4 py-3">'.$user["user_name"].'</td>
                                                    </tr>';

                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                    <!-- Start coding here -->
                    <div class="mt-10 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Titre</th>
                                        <th scope="col" class="px-4 py-3">Catégorie</th>
                                        <th scope="col" class="px-4 py-3">Date</th>
                                        <th scope="col" class="px-4 py-3">utilisateur</th>
                                        <th scope="col" class="px-4 py-3">nb likes</th>
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                if (! empty( $_GET['category'] )) :
                                    $questions = Database::get_questions_with_category($_GET['category'], $_GET['search']);
                                else :
                                    $questions = Database::get_questions_with_string($_GET['search']);
                                endif;

                                    foreach ($questions as $question){
                                        echo '
                                                <tr class="border-b dark:border-gray-700">
                                                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><a href="single-question.php?id='.$question["id"].'">'.$question["title"].'</a></th>
                                                    <td class="px-4 py-3"><span class="flex py-1">';
                                                echo Component::display_categories($question["id"]);
                                                echo '</span></td>
                                                    <td class="px-4 py-3">'.$question["creation_date"].'</td>
                                                    <td class="px-4 py-3">'.$question["user_name"].'</td>
                                                    <td class="px-4 py-3">'.$question["number_likes"].'</td>
                                                </tr>';

                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</div>

</div>

<?php
require_once 'includes/footer.php';
