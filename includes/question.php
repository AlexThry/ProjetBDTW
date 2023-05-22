<?php
/**
 * Display a question and edit buttons if user is admin.
 */

if ( ! key_exists( 'id', $_GET ) ) {
	exit();
}

$id       = htmlentities( $_GET['id'] );
$question = Database::get_question( $id );

// *** todo: check if user is admin
$is_admin = true;
// *** todo: check if has already like the question
$is_liked = true;

/*
 ***todo: Afficher les categories à la place de #flowbite et
mettant les bonnes couleurs comme dans le fichier
assets/js/script.js line 80
=> crée un composant qui affiche les categories en lui donnant
un array de categories (pour etre reutilisé sur admin par ex)


Pour éditer une question, il faut rediriger vers la meme page avec un attribut $_GET['edit'],
si l'attribut existe, on affiche un formulaire d'édition à la place de la question. (voir includes/new-question-form.php)
*/

// *** todo: interactivité like
if ( key_exists( 'liked', $_GET ) ) {
	$is_liked = true;
	// update DB
}

// *** todo: interactivité edit button
if ( key_exists( 'edit', $_GET ) ) {
	if ( $is_admin ) {
		echo 'todo: faire le formulaire d\'édition de question';
	} else {
		AlertManager::display_warning( "T'es un petit malin toi ;). Désolé tu n'as pas le droit de modifier cette question." );
	}
} else {
	?>
	<header class="mb-4 not-format text-black dark:text-white">
		<h1 class="mb-2 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
			<?php echo htmlentities( $question['title'] ); ?>
		</h1>

		<?php // Create component to replace div below. ?>
		<div class="flex algin-center">
			<div class="flex flex-wrap mb-4"><a
					class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 hover:bg-blue-200 dark:hover:bg-blue-300 dark:text-blue-800 mb-2"
					href="/blog/tag/flowbite/">#Flowbite</a></div>
			<div class="flex flex-wrap mb-4"><a
					class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 hover:bg-red-200 dark:hover:bg-red-300 dark:text-red-800 mb-2"
					href="/blog/tag/flowbite/">#Flowbite</a></div>
			<div class="flex flex-wrap mb-4"><a
					class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 hover:bg-yellow-200 dark:hover:bg-yellow-300 dark:text-yellow-800 mb-2"
					href="/blog/tag/flowbite/">#Flowbite</a></div>
		</div>

		<div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
			<div class="text-base">
				Publiée le 
				<time class="inline" pubdate datetime="<?php echo htmlentities( $question['creation_date'] ); ?>" title="<?php echo format_date( $question['creation_date'] ); ?>"><?php echo format_date( $question['creation_date'] ); ?></time>
			</div>
			<?php if ( $is_admin ) : ?>
				<a href="?id=<?php echo htmlentities( $id ); ?>&edit=true" class="inline-flex items-center ml-2 text-sm font-medium text-blue-600 md:ml-2 dark:text-blue-500 hover:underline">Modifier</a>
			<?php endif; ?>
		</div>
	</header>

	<article class="pt-8 pb-12 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900 flex items-start gap-10">
		<div class="flex flex-col gap-2 items-center dark:text-white">
			<a href="?id=<?php echo htmlentities( $id ); ?>&liked=true" type="button" class="<?php echo $is_liked ? 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500'; ?> cursor-pointer">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
				</svg>
				<span class="sr-only">J'aime<?php echo intval( htmlentities( $question['number_likes'] ) ) > 1 ? 's' : ''; ?></span>
			</a>
			<p class="text-xl font-bold"><?php echo htmlentities( $question['number_likes'] ); ?></p>
			<p>J'aime<?php echo intval( htmlentities( $question['number_likes'] ) ) > 1 ? 's' : ''; ?></p>
		</div>
		<p class="text-gray-800 dark:text-gray-200">
			<?php echo html_entity_decode( $question['content'] ); ?>
		</p>
	</article>
	<?php
}
