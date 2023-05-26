<?php
require_once 'functions.php';

// Checks if user is connected
if ( ! get_user() ) {
	header( 'Location: connection.php' );
	exit();
}

$active_tab    = isset( $_GET['tab'] ) ? $_GET['tab'] : 'user_data';
$is_admin      = get_user()['is_admin'];
$error_message = isset( $_GET['error'] ) ? $_GET['error'] : null;

// Check if user is allowed to get on the interface_admin tab
if( ! $is_admin && $active_tab === 'interface_admin') {
	header('Location: connection-admin.php');
	exit();
}

require_once 'includes/header.php';

// Display error messages
if( $error_message !== null ) {
	AlertManager::display_error(html_entity_decode($error_message));
}
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
							'user_questions'    => array(
								'label'    => 'Mes questions',
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
					?>

					<?php foreach ( $buttons as $tab_slug => $tab ) : ?>
						<?php $is_selected = $active_tab === $tab_slug; ?>
						<li>
							<a href="?tab=<?php echo htmlentities( $tab_slug ); ?>" class="<?php echo $is_selected ? 'bg-blue-700 text-white dark:text-white' : 'text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white'; ?> flex items-center p-2 text-base font-normal rounded-lg transition duration-75 group">
								<svg aria-hidden="true" class="<?php echo $is_selected ? 'text-white' : 'text-gray-400 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white'; ?> flex-shrink-0 w-6 h-6 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<?php echo $tab['svg_path']; ?>
								</svg>
								<span class="ml-3"><?php echo $tab['label']; ?></span>
							</a>
						</li>
					<?php endforeach; ?>
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
					// <--------------------- Mes infos (TODO) --------------------------->
					require_once 'includes/account/data-form.php';
					break;
				case 'user_questions':
					// <--------------------- Mes questions ------------------------------>
				?>
					<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
						<h1 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white" id="content">Mes questions</h1>
						<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">Retrouvez toutes les questions que vous avez posées ainsi que leurs réponses.</p>
					</div>
					<?php

					require_once 'user-questions.php';
					break;

				case 'interface_admin':
					?>
					<!-- Add a category -->
					<section class="bg-white dark:bg-gray-900 ml-">
						<div class="py-4 ml-2">
							<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Ajouter une nouvelle catégorie</h2>
							<form action="add-category.php" method="post">
								<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
									<div class="sm:col-span-2">
										<label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de la catégorie</label>
										<input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez un nom de catégorie" required="">
									</div>


								</div>
								<button type="submit" name="button" class="flex items-center px-2 py-1 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">Soumettre</button>

							</form>
						</div>
					</section>

					<!-- Suppress a category -->
					<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Supprimer une catégorie</h2>
					<button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Sélectionner une catégorie<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>

					<form action="suppress-category.php" method="post">
						<div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
							<ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
								<?php
								$categories = Database::get_categories();
								foreach ( $categories as $category ) :
								?>
									<li data-cat="<?php echo $category['label']; ?>">
										<button type="submit" name="suppress_choice" class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value=<?php echo $category['label']; ?> ><?php echo $category['label']; ?></button>
									</li>
								<?php
								endforeach;
								?>
							</ul>
						</div>
					</form>

					<!-- Displays unvalidated questions -->
					<h2 class="mt-4 mb-4 text-xl font-bold text-gray-900 dark:text-white">Les questions invalidées</h2>
					<?php
						$unvalidated_questions = Database::get_unvalidated_questions();
						Component::display_questions($unvalidated_questions, "with-validation-action");
					?>

					<!-- Displays unanswered questions -->
					<h2 class="mt-4 mb-4 text-xl font-bold text-gray-900 dark:text-white">Les questions non répondues</h2>
					<?php
						$unanswered_questions = Database::get_unanswered_questions();
						Component::display_questions($unanswered_questions, "with-answer-action");
					?>


				<?php break;

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
