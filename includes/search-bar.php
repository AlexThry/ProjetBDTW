<?php

$genre  = !empty( $_GET['category'] ) ? htmlentities( $_GET['category'] ) : null;
$search = !empty( $_GET['search'] ) ? htmlentities( $_GET['search'] ) : null;

$random = generate_random_string();

?>

<form class="sm:max-w-lg w-450" action="<?= get_home_url(); ?>" method="GET">
    <div class="flex search-cat-dropdown-container">
        <input type="hidden" class="search-hidden-genre" name="category" value="<?= $genre; ?>">

        <button data-dropdown-toggle="dropdown-cat-search-<?= $random; ?>" class="dropdown-search-cat-button flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
            <span class="dropdown-cat-value"><?= $genre ?? 'Toutes catégories' ?></span>
            <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <div id="dropdown-cat-search-<?= $random; ?>" class="dropdown-cat-search z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li data-cat="">
                    <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Toutes catégories</button>
                </li>
                <?php
                $categories = Category::all();
                foreach ( $categories as $category ) :
                    ?>
                    
                    <li data-cat="<?= $category->get_label() ?>">
                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?= $category->get_label() ?></button>
                    </li>
                
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="relative w-full">
            <input value="<?= $search ?? ''; ?>" type="search" id="search-dropdown" name="search" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Rechercher une question...">
            <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span class="sr-only">Chercher</span>
            </button>
        </div>
    </div>
</form>


