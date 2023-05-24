<?php
	require_once 'functions.php';
	// Test if user is connected
if ( ! get_user() ) {
	header( 'Location: connection.php' );
}

$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'user_data';
$is_admin = get_user()['is_admin'];
// Check if user is allowed to get on this page
if( ! $is_admin && $active_tab === 'interface_admin') {
	header('Location: connection-admin.php');
}
require_once 'includes/header.php';
?>

<div class="content">
	<section class="lg:flex">

		<aside class="full-height w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
			<div style="height: calc(100% - 64px);" class="flex flex-col justify-between overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
				<ul class="space-y-2">
					<?php
					$buttons = array(
						'user_data'     => array(
							'label'    => 'Mes données',
							'svg_path' => '<path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>',
						),
						'user_books'    => array(
							'label'    => 'Mes livres',
							'svg_path' => '<path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>',
						),
					);

					// Add the interface_admin button, but only if the user is connected as an admin
					if( $is_admin ) {
						$buttons['interface_admin'] = array(
							'label'    => 'Interface administrateur',
							'svg_path' => '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>',
						);
					}

					foreach ( $buttons as $tab_slug => $tab ) {
						$is_selected = $active_tab === $tab_slug;
						?>
						<li>
							<a href="?tab=<?php echo htmlentities( $tab_slug ); ?>" class="<?php echo $is_selected ? 'bg-blue-700 text-white dark:text-white' : 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white'; ?> flex items-center p-2 text-base font-normal rounded-lg transition duration-75 group">
								<svg aria-hidden="true" class="<?php echo $is_selected ? 'text-white' : 'text-gray-400 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white'; ?> flex-shrink-0 w-6 h-6 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<?php echo $tab['svg_path']; ?>
								</svg>
								<span class="ml-3"><?php echo $tab['label']; ?></span>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
				<ul class="space-y-2">
					<li>
						<a href="logout.php" class="flex items-center p-3 text-sm font-medium text-red-600 border-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-600 dark:text-red-500">
							<svg class="w-5 h-5 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 6a3 3 0 11-6 0 3 3 0 016 0zM14 17a6 6 0 00-12 0h12zM13 8a1 1 0 100 2h4a1 1 0 100-2h-4z"></path></svg>
							Déconnexion
						</a>
					</li>
				</ul>
			</div>
		</aside>

		<article class="flex-auto w-full min-w-0 lg:static lg:max-h-full lg:overflow-visible">
			<div class="flex w-full">
				<div class="flex-auto min-w-0 pt-6 lg:px-8 lg:pt-8 pb:12 xl:pb-24 lg:pb-16">

			<?php

			switch ( $active_tab ) {
				case 'user_data':
					// Troisième tab: Mon infos (TODO) ------------------------------------------>
					require_once 'includes/account/data-form.php';
					break;
				case 'user_books':
					$books = Database::get_user_books( get_user()['id'] );

					?>
					<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
						<h1 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white" id="content">Vos livres terminés</h1>
						<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">Retrouvez toutes les oeuvres que vous avez lues. Ajoutez, modifiez ou supprimez des titres.</p>
					</div>
					<?php
					Component::display_books( $books );
					//mathys est trop beau
					break;
				case 'interface_admin':
					?>
				<section class="bg-white dark:bg-gray-900 ml-">
					<div class="py-4 ml-2">
						<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Ajouter une nouvelle catégorie</h2>
						<form action="add_category.php" method="post">
							<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
								<div class="sm:col-span-2">
									<label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de la catégorie</label>
									<input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez un nom de catégorie" required="">
								</div>


							</div>
							<button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" value="Soumettre">
							</button>


						</form>
						</div>
					</section>
					<!-- Supprimer une catégorie -->
					<form class="sm:max-w-lg w-450" action="<?php echo get_home_url(); ?>" method="GET">
						<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Supprimer une catégorie</h2>
						<div class="flex search-cat-dropdown-container ml-2">
							<input type="hidden" name="start" value="0">
							<input type="hidden" name="limit" value="<?php echo $limit; ?>">
							<input type="hidden" name="sort" value="<?php echo $sort; ?>">
							<input type="hidden" name="order" value="<?php echo $order; ?>">
							<input type="hidden" class="search-hidden-genre" name="genre" value="<?php echo $genre; ?>">

							<button data-dropdown-toggle="dropdown-cat-search-<?php echo $random; ?>" class="dropdown-search-cat-button flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-white-100 border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button"><span class="dropdown-cat-value"><?php echo isset( $genre ) ? $genre : 'Sélectionner une valeur à supprimer'; ?></span> <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
							<div id="dropdown-cat-search-<?php echo $random; ?>" class="dropdown-cat-search z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
								<ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
									<?php
									$categories = Database::get_categories();
									foreach ( $categories as $category ) {
										?>

										<li data-cat="<?php echo $category['label']; ?>">
											<button type="button" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?php echo $category['label']; ?></button>
										</li>

									<?php }; ?>
								</ul>
							</div>

					<?php

					break;


				default:
					AlertManager::display_error( 'Cet onglet n\'existe pas.' );
					break;
			}

			?>

			</div>
			</div>
		</article>
	</section>
</div>

<?php
require_once 'includes/footer.php';
