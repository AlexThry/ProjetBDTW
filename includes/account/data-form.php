<?php

$user = get_user();
if ( $user === null ) die();

$new_password     = !empty($_POST['new_password']) ? $_POST['new_password'] : null;
$confirm_password = !empty($_POST['new_confirm_password']) ? $_POST['new_confirm_password'] : null;
$save_label       = null;
$errors           = [];

if ($new_password === null && $confirm_password !== null) {
    $errors[] = 'Vous devez renseigner un nouveau mot de passe.';
}
if($new_password !== null && $confirm_password === null) {
    $errors[] = 'Vous devez confirmer le nouveau mot de passe.';
}
if($new_password !== null && $confirm_password !== null && $new_password !== $confirm_password) {
    $errors[] = 'Les mots de passe ne correspondent pas.';
}

if($new_password !== null && !password_is_secure_enough($new_password)) {
    $errors[] = "Votre mot de passe n'est pas assez sécurisé.<br /><br />
        Il doit comporter :<br /><br />
        <ul>
            <li>Au moins 8 caractères.</li>
            <li>Au moins 1 lettre minuscule.</li>
            <li>Au moins 1 lettre majuscule.</li>
            <li>Au moins 1 chiffre.</li>
        </ul>";
}

if(empty($errors) && !empty($_POST)) {
    $new_password = $new_password === null ? get_user()->get_password() : $new_password;
    $submitted_args = remove_falsy_values(
        array(
            'profile_url' => isset( $_POST['profile_url'] ) ? addslashes( $_POST['profile_url'] ) : null,
            'first_name'  => isset( $_POST['first_name'] ) ? addslashes( $_POST['first_name'] ) : null,
            'last_name'   => isset( $_POST['last_name'] ) ? addslashes( $_POST['last_name'] ) : null,
            'email'       => isset( $_POST['email'] ) ? addslashes( $_POST['email'] ) : null,
            'password'    => $new_password,
        )
    );

    $user->update($submitted_args);
    refresh_user();

    $user = get_user();

    $save_label = 'Vos données ont bien été mises à jour.';
}



?>

<div class="pb-4 mb-8 border-b border-gray-200 dark:border-gray-700"> 
	<h1 class="inline-block mb-2 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white dark:text-white" id="content">Mes données</h1>
	<p class="mb-4 text-lg text-gray-600 dark:text-gray-400">Ajoutez, modifiez ou supprimez vos données.</p>
</div>

<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
	// ...
	plugins: [
	  // ...
	  require('@tailwindcss/forms'),
	],
  }
  ```
-->
<form method="POST" action="account.php">
	<div class="space-y-12">
		<div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
			<h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Profil</h2>
			<p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-300">Ces informations seront partagées publiquement. Soyez donc
				prudent avec ce que vous souhaitez partager.</p>

			<?php

			if ( $save_label !== null ) {
				?>
				<hr class="my-6 border-gray-200 dark:border-gray-700" />
				<?php
                AlertManager::display_success( $save_label );
			}

			if ( !empty($errors) ) {
				?>
				<hr class="my-6 border-gray-200 dark:border-gray-700" />
				<?php
                foreach ($errors as $error) {
				    AlertManager::display_error( $error );
                }
			}

			?>

			<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
				<div class="sm:col-span-4">
					<label for="user_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Nom
						d'utilisateur</label>
					<div class="mt-2">
						<div
							class="flex rounded-md focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
							<input type="text" name="user_name" id="user_name" autocomplete="user_name" disabled
								value="<?= $user->get_user_name() ?>"
								class="pl-3 text-gray-500 sm:text-sm block flex-1 rounded bg-gray-50 border-gray-300 py-1.5 pl-1 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
						</div>
					</div>
				</div>

				<div class="col-span-full">
					<label for="photo" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Photo</label>
					<div class="mt-2 flex items-center gap-x-3">
						<img class="w-16 h-16 rounded-full" src="<?= ! empty( $profile_url ) ? $profile_url : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80'; ?>" alt="Photo de profil" />

						<div class="flex-1">
							<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Changer d'image</label>
							<input
							name="profile_url"
							type="text" id="profile_url" autocomplete="off"
							value="<?= $user->get_profile_url() ?>"
							class="block w-full rounded-md bg-gray-50 border-gray-300 py-1.5 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
							<p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
						</div>
			
					</div>
				</div>
	  

			</div>
		</div>

		<div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
			<h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Informations personnelles</h2>
			<p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-300">Utilisez une adresse avec laquelle vous pouvez recevoir des
				emails.</p>

			<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
				<div class="sm:col-span-3">
					<label for="first-name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Prénom</label>
					<div class="mt-2">
						<input type="text" name="first_name" id="first-name" autocomplete="given-name"
							  value="<?= $user->get_first_name() ?>"
							class="block w-full rounded-md bg-gray-50 border-gray-300 py-1.5 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
					</div>
				</div>

				<div class="sm:col-span-3">
					<label for="last-name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Nom</label>
					<div class="mt-2">
						<input type="text" name="last_name" id="last-name" autocomplete="family-name"
							value="<?= $user->get_last_name() ?>"
							class="block w-full rounded-md py-1.5 bg-gray-50 border-gray-300 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
					</div>
				</div>

				<div class="sm:col-span-4">
					<label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email</label>
					<div class="mt-2">
						<input id="email" name="email" type="email" autocomplete="email"
						value="<?= $user->get_email(); ?>"
							class="block w-full rounded-md py-1.5 bg-gray-50 border-gray-300 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
					</div>
				</div>

			</div>
		</div>

		<div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
			<h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Changer de mot de passe</h2>


			<div class="sm:col-span-4 mt-10 ">
				<label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Nouveau mot de passe</label>
				<div class="mt-2">
					<input id="new_password" name="new_password" type="password" autocomplete="off"
						class="block w-full rounded-md py-1.5 bg-gray-50 border-gray-300 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
				</div>
			</div>

			<div class="sm:col-span-4 mt-4">
				<label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Confirmation</label>
				<div class="mt-2">
					<input id="new_confirm_password" name="new_confirm_password" type="password" autocomplete="off"
						class="block w-full rounded-md py-1.5 bg-gray-50 border-gray-300 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
				</div>
			</div>

		</div>
	</div>


	<div class="mt-6 flex items-center justify-end gap-x-6">
		<a href="account.php" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Annuler</a>
		<button type="submit"
			class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sauvegarder</button>
	</div>
</form>
