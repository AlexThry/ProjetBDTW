<?php
/**
 * Contains the connection page.
 */

require_once 'includes/header.php';

?>

<section class="bg-white dark:bg-gray-800 flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

	<div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
		<div class="full-width pb-14">
			<div class="sm:mx-auto sm:w-full sm:max-w-sm">
				<h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">Admin</h2>
			</div>

			<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
				<form class="space-y-6" action="login.php" method="POST">
					<?php
					if ( isset( $_GET['connection_error'] ) ) {
						AlertManager::display_error( html_entity_decode( $_GET['connection_error'] ) );
					}
					?>

				<div>
					<label for="connection-user-name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Nom d'utilisateur</label>
					<div class="mt-2">
					<input  <?php display_input_value( 'user_name' ); ?>  type="text" name="connection-user-name" id="connection-user-name-input-creation" placeholder="Saisissez un nom d'utilisateur" required autocomplete="off" required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					</div>
				</div>

				<div>
					<div class="flex items-center justify-between">
					<label for="connection-password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Mot de passe</label>
					</div>
					<div class="mt-2">
					<input type="password" name="connection-password" id="connection-password-input-creation" placeholder="Saisissez un mot de passe" autocomplete="current-connection-password" required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					</div>
				</div>

				<div>
					<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Se connecter</button>
				</div>
				</form>

			</div>
		</div>
        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/authentication/illustration.svg" alt="">
	</div>

</section>

<?php require_once 'includes/footer.php'; ?>
