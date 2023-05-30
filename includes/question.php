<?php

/**
 * Display a question and edit buttons if user is admin.
 */


// Check if question's id is given
$question_id   = key_exists('id', $_GET) ? htmlentities( $_GET['id'] ) : null;
if ( $question_id === null ) {
	header("Location: index.php?category=&search="); exit;
}

$user          = get_user() ? get_user() : null;
$is_admin      = $user && $user['is_admin'];
$question_user = Database::get_user_by_question_id($question_id)['user_name'];
$question      = Database::get_question( $question_id );
$title         = isset($_POST['question_title']) ? htmlentities($_POST['question_title']) : null;
$content       = isset($_POST['html-input']) ?htmlentities($_POST['html-input']) : null;
// Ne pas confondre liked et is_liked (is_liked est l'état en BDD, liked est l'état voulu)
$is_liked      = $user !== null ? Database::is_liked( $question_id, $user['id'] ) : false;
$liked         = $user !== null && key_exists( 'liked', $_GET )  ? (bool)$_GET['liked'] : $is_liked;
$like_url      = "?id=".htmlentities( $question_id )."&liked=".(int)!$liked;

// Question modification
if ( $title !== null && $content !== null) {
	$categories_ids = [];
	foreach ($_POST as $key => $value) {
		if (strpos($key, 'checkbox-item-') === 0) {
			$categories_ids[] = htmlentities($value);
		}
	}
	Database::modify_question( $question_id, $title, $content, $categories_ids );
}

$question = Database::get_question( $question_id );

// *** todo: check if has already like the question

/*
 ***todo: Afficher les categories à la place de #flowbite et
mettant les bonnes couleurs comme dans le fichier
assets/js/script.js line 80
=> crée un composant qui affiche les categories en lui donnant
un array de categories (pour etre reutilisé sur admin par ex)


Pour éditer une question, il faut rediriger vers la meme page avec un attribut $_GET['edit'],
si l'attribut existe, on affiche un formulaire d'édition à la place de la question. (voir includes/new-question-form.php)
*/

// Like modification
if ( $liked !== $is_liked ) {
	Database::toggle_user_like( $question_id, $user['id'] );
}

$like_number   = Database::get_likes_number( $question_id );

// *** todo: interactivité edit button
if ( key_exists( 'edit', $_GET ) ) :
	if ( !$is_admin ) :
		AlertManager::display_warning( "T'es un petit malin toi ;). Désolé tu n'as pas le droit de modifier cette question." );
	else : ?>
		<h1 class="mb-2 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">Modifier la question</h1>
		<form method="post" action="single-question.php?id=<?php echo $question_id ?>" class="mb-10">
			<label for="question_title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Nom de la question</label>
			<input type="text" name="question_title" id="question_title" autocomplete="question_title" value="<?php echo html_entity_decode( $question['title'] ); ?>" class="mb-4 block w-full rounded-md py-1.5 bg-gray-50 border-gray-300 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="janesmith">
			<label for="content" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Contenu</label>

			<div class="markdown-editor-container ">
				<textarea required name='content' rows="8" class="block p-2.5 mb-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					<?php
				// les sauts de lignes ne s'affichent pas dans le textarea
				echo html_entity_decode( $question["content"] );
				?>
				</textarea>
				<label for="renderer" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Rendu</label>
				<div class="sm:col-span-2" name="renderer">
					<div class="html-markdown-renderer block p-2.5 w-full mb-4" rows="8" placeholder="Your description here"><mark class="text-gray-800 dark:text-gray-200 html-markdown-renderer flex-1"><?php echo html_entity_decode($question['content']) ?></mark></div>
					<input type="hidden" class="html-input" name="html-input">
				</div>
			</div>


			<div id="categories-renderer" class="sm:col-span-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg flex w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-white"></div>
			<div class="mt-4 sm:col-span-2">
				<button id="dropdownCheckboxButton" data-dropdown-toggle="categories-dropdown" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium inline-flex items-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">Catégories <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>

				<div id="categories-dropdown" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-md dark:bg-gray-700 dark:divide-gray-600">
					<ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
						<?php
						$has_cat = Database::get_categories_id_by_question($question_id);
						$i = 0;
						foreach ( $categories as $category ) {
							$name = 'checkbox-item-' . strval( $i );
							?>
								<li>
									<div class="flex items-center">
									<?php if (in_array($category['id'], $has_cat)): ?>
										<input checked id="<?php echo htmlentities( $name ); ?>" name="<?php echo htmlentities( $name ); ?>" type="checkbox" value="<?php echo htmlentities( $category['id'] ); ?>" data-cat-label='<?php echo ucfirst( htmlentities( $category['label'] ) ); ?>' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
									<?php else: ?>
											<input id="<?php echo htmlentities( $name ); ?>" name="<?php echo htmlentities( $name ); ?>" type="checkbox" value="<?php echo htmlentities( $category['id'] ); ?>" data-cat-label='<?php echo ucfirst( htmlentities( $category['label'] ) ); ?>' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
									<?php endif; ?>
										<label for="<?php echo htmlentities( $name ); ?>" class="flex-1 ml-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo ucfirst( htmlentities( $category['label'] ) ); ?></label>
									</div>
								</li>
							<?php
							$i++;
						}
						?>
					</ul>
				</div>
				<input type="submit" class="cursor-pointer mt-5 rounded-md bg-indigo-600 mb-4 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" value='Valider'>
			</div>
		</form>
	<?php endif ?>
<?php else : ?>
	<header class="mb-4 not-format text-black dark:text-white">
		<h1 class="mb-2 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
			<?php echo html_entity_decode( $question['title'] ); ?>
		</h1>
		<?php Component::display_categories( $question_id ); ?>

		<div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
			<div class="text-base">
				Publiée le
				<time class="inline" pubdate datetime="<?php echo htmlentities( $question['creation_date'] ); ?>" title="<?php echo format_date( $question['creation_date'] ); ?>"><?php echo format_date( $question['creation_date'] ); ?></time> par <?php echo htmlentities($question_user); ?>
			</div>
			<?php if ( $is_admin ) : ?>
				<a href="?id=<?php echo htmlentities( $question_id ); ?>&edit=true" class="inline-flex items-center ml-2 text-sm font-medium text-blue-600 md:ml-2 dark:text-blue-500 hover:underline">Modifier</a>
			<?php endif; ?>
		</div>
	</header>

	<article class="pt-8 pb-12 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900 flex items-start gap-10 html-markdown-renderer ">
		<div class="flex flex-col gap-2 items-center dark:text-white">
			<a type="button"
				href="<?php echo $like_url ?>"
				<?= $liked ? 'style="color:white;"' : ''; ?>
				 class="<?= $liked ? 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : 'text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500'; ?> cursor-pointer"
			>
				<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
				</svg>
				<span class="sr-only">J'aime<?= intval( htmlentities( $like_number ) ) > 1 ? 's' : ''; ?></span>
			</a>
			<p class="text-xl font-bold"><?= htmlentities( $like_number ); ?></p>
			<p>J'aime<?= intval( htmlentities( $like_number ) ) > 1 ? 's' : ''; ?></p>
		</div>
		<mark class="text-gray-800 dark:text-gray-200 html-markdown-renderer flex-1">
			<?= html_entity_decode( $question['content'] ); ?>
		</mark>
	</article>
<?php endif ?>


