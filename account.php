<?php
require_once 'functions.php';

$user = get_user();
// Checks if user is connected
if ( $user === null  ) {
	header( 'Location: connection.php' );
	exit();
}

$active_tab    = $_GET['tab'] ?? 'user_data';
$is_admin      = $user !== null && $user->is_admin();
$error_message = $_GET['error'] ?? null;

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
							'user_data'     => [
								'label'    => 'Mes données',
								'svg_path' => '<path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>',
							],
							'user_questions' => [
								'label'    => 'Mes questions',
								'svg_path' => '<path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>',
							],
							'user_questions_favoris' => [
								'label'    => 'Mes favoris',
								'svg_path' => '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>',
							]
						);
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
					// Premier tab: Mes questions --------------------------------------------------->
                    $questions = $user->get_questions();
					?>
					<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
						<h1 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white" id="content">Mes questions</h1>
						<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">Retrouvez toutes les questions que vous avez posées ainsi que leurs réponses.</p>
					</div>
					<?php
					Component::display_questions($questions, "with-likes");
					break;

				case 'user_questions_favoris':
					//Mes favoris --------------------------------------------------->
					$questions = $user->get_favorite_questions();

					?>
					<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-800">
						<h1 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white" id="content">Mes favoris</h1>
						<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">Retrouvez toutes les questions que vous avez aimées ainsi que leur réponse.</p>
					</div>
					<?php
					Component::display_questions($questions, "with-likes");
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
