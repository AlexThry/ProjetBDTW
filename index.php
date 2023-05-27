<?php
	require_once 'includes/header.php';
	$is_admin = get_user() ? get_user()['is_admin'] : false;
?>

<div class="content">
	<?php if ( empty( $_GET ) ) : ?>
		<?php if($is_admin) : ?>
			<?php require_once 'includes/admin-dashboard.php' ?>
		<?php else : ?>
			<section class="relative bg-white dark:bg-gray-800">
				<div class="pb-80 pt-16 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
					<div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
						<div class="sm:max-w-lg">
							<h1 class="font text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Ne laissez aucune question sans réponse</h1>
							<p class="mt-4 text-xl text-gray-500 dark:text-gray-300">Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions sur le cours sur notre site interactif et bénéficiez des réponses de nos experts!</p>
						</div>
						<div class="mt-10">
							<?php require 'includes/search-bar.php'; ?>
							<div class="mx-auto max-w-screen-xl">
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
													<th scope="col" class="px-4 py-3">nombre de like</th>
														<span class="sr-only">Actions</span>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												// Gets the questions with their respective username, number of likes, and categories
												$questions = Database::get_questions(true, true, true);

												// Variables used to display custom colors for the categories
												$default_color = "blue";
												$category_to_color = [
													"git"        => "pink",
													"javascript" => "yellow",
													"HTML"       => "red",
													"CSS"        => "blue",
													"PHP"        => "indigo",
													"BD"         => "green",
												];
												?>

												<?php foreach ($questions as $question) : ?>
													<tr class="border-b dark:border-gray-700">
														<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
															<a href="single-question.php?id=<?php echo $question["id"] ?> "> <?php echo $question["title"] ?> </a>
														</th>
														<td class="px-4 py-3">
															<?php
															foreach ($question["categories"] as $category){
																if(! key_exists($category['label'], $category_to_color)) {
																	$color = $default_color;
																} else {
																	$color = $category_to_color[$category['label']];
																}
																echo "<div class='flex flex-wrap mb-4'><a class='bg-$color-100 text-$color-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-$color-200 hover:bg-$color-200 dark:hover:bg-$color-300 dark:text-$color-800 mb-2' href='/blog/tag/flowbite/'>#".$category['label']."</a></div>";
															}
															?>
														</td>
														<td class="px-4 py-3"><?php echo $question["creation_date"] ?></td>
														<td class="px-4 py-3"><?php echo $question["user_name"] ?></td>
														<td class="px-4 py-3"><?php echo $question["number_likes"] ?></td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
