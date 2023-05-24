<?php require_once 'includes/header.php'; ?>

<div class="content">

	<?php if ( empty( $_GET ) ) : ?>
	<section class="relative bg-white dark:bg-gray-800">
		<div class="pb-80 pt-16 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
			<div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
			<div class="sm:max-w-lg">
				<h1 class="font text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">Ne laissez aucune question sans réponse</h1>
				<p class="mt-4 text-xl text-gray-500 dark:text-gray-300">Trouvez des solutions et approfondissez vos connaissances en posant toutes vos questions sur le cours sur notre site interactif et bénéficiez des réponses de nos experts!</p>
			</div>
			<div>
				<div class="mt-10">
					<!-- Decorative image grid -->
					<div aria-hidden="true" class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
						<div class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
						<div class="flex items-center space-x-6 lg:space-x-8">
							<div class="rounded-lg sm:opacity-0 lg:opacity-100">
								<img src="assets/images/index-image.svg" alt="" class="h-full w-full object-cover object-center">
							</div>
						</div>
					</div>

					<!-- <a href="#" class="inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-center font-medium text-white hover:bg-indigo-700">Shop Collection</a> -->

					<?php require 'includes/search-bar.php'; ?>

						<div class="mx-auto max-w-screen-xl px-4 lg:px-12">
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
										
										$questions = Database::get_username_questions();

										foreach ($questions as $question){
											echo '
													<tr class="border-b dark:border-gray-700">
														<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"><a href="single-question.php?id='.$question["id"].'">'.$question["title"].'</a></th>
														<td class="px-4 py-3">';
														foreach ($question["categories"] as $category){
															echo Database::get_display_categories($category);
														}
													echo '</td>
														<td class="px-4 py-3">'.$question["creation_date"].'</td>
														<td class="px-4 py-3">'.$question["user_name"].'</td>
														<td class="px-4 py-3">'.$question["number_likes"].'</td>
													</tr>';

										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>


</div>

<?php
require_once 'includes/footer.php';
