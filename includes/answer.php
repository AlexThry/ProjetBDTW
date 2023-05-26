<?php
/**
 * Display an answer and edit buttons if user is admin.
 */

if ( ! key_exists( 'id', $_GET ) ) {
	exit();
}

$id     = htmlentities( $_GET['id'] );
$answer = Database::get_question_answer( $id );
$user = Database::get_user( $answer['id_user'] );

// todo : check if user is admin
$is_admin = true;


if ($user['image_url']) {
	$admin_image = $user['image_url'];
} else {
	$admin_image = "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80";
}
// todo: recup user et afficher son nom, prenom, image url si oui sinon mettre une image par defaut

if ( key_exists( 'delete_answer', $_GET ) ) {
	// delete answer in db et mettre à jour l'etat de la question...
	header( 'Location: index.php' );
} elseif ( key_exists( 'edit_answer', $_GET ) ) {
	if ( $is_admin ) {
		echo 'todo: faire le formulaire d\'édition de la réponse';
	} else {
		AlertManager::display_warning( "T'es un petit malin toi ;). Désolé tu n'as pas le droit de modifier cette question." );
	}
} else {
	?>
	<article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900 border border-gray-200 rounded-lg dark:border-gray-700">
		<footer class="flex justify-between items-center mb-2">
			<div class="flex items-center">
				<p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"><img
						class="mr-2 w-6 h-6 rounded-full"
						src="<?php echo $admin_image ?>"
						alt="Michael Gough"><?php echo $user['first_name'] . " " . $user['last_name'] ?></p>
				<?php if ( $answer != null && key_exists( 'creation_date', $answer ) ) : ?>
					<p class="text-sm text-gray-600 dark:text-gray-400">
						<time class="inline" pubdate datetime="<?php echo htmlentities( $answer['creation_date'] ); ?>" title="<?php echo format_date( $answer['creation_date'] ); ?>"><?php echo format_date( $answer['creation_date'] ); ?></time>
					</p>
				<?php endif; ?>
			</div>

			<?php if ( $is_admin ) : ?>
				<button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
					class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
					type="button">
					<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
						</path>
					</svg>
					<span class="sr-only">Options</span>
				</button>
				<!-- Dropdown menu -->
				<div id="dropdownComment1"
					class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
					<ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
						aria-labelledby="dropdownMenuIconHorizontalButton">
						<li>
							<a href="?id=<?php echo htmlentities( $id ); ?>&edit_answer=true"
								class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
						</li>
						<li>
							<a href="?id=<?php echo htmlentities( $id ); ?>&delete_answer=true"
								class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
						</li>
					</ul>
				</div>
			<?php endif; ?>
		</footer>
		<p class="text-gray-800 dark:text-gray-200">
			<?php 
				if ($answer != null ) {
					echo html_entity_decode( $answer['content'] ); 
				}
			?>
		</p>

		<!-- Pour aller plus loin. Ajouter bouton répondre -->
		<!-- <div class="flex items-center mt-4 space-x-4">
			<button type="button"
				class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
				<svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
				Répondre
			</button>
		</div> -->
	</article>
	<?php
}
