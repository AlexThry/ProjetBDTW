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
								<img src="https://img.freepik.com/vecteurs-libre/autogestion-coaching-vie-homme-doutant-interrogeant-brainstorming-crise-identite-delire-confusion-mentale-concept-sentiments-confus_335657-686.jpg?w=2000&t=st=1684596403~exp=1684597003~hmac=eff7995b8ee7c1020b09f53b595d887d3b5f805ee5e40becde09b084b06045c8" alt="" class="h-full w-full object-cover object-center">
							</div>
						</div>
						</div>
					</div>

					<!-- <a href="#" class="inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-center font-medium text-white hover:bg-indigo-700">Shop Collection</a> -->

					<?php require 'includes/search-bar.php'; ?>

					<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
						<div class="mx-auto max-w-screen-xl px-4 lg:px-12">
							<!-- Start coding here -->
							<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
								<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
									<div class="w-full md:w-1/2">
										<form class="flex items-center">
											<label for="simple-search" class="sr-only">Search</label>
											<div class="relative w-full">
												<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
													<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
													</svg>
												</div>
												<input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
											</div>
										</form>
									</div>
									<div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
										<button type="button" class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
											<svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
												<path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
											</svg>
											Add product
										</button>
										<div class="flex items-center space-x-3 w-full md:w-auto">
											<button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
												<svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
													<path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
												</svg>
												Actions
											</button>
											<div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
												<ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
													<li>
														<a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
													</li>
												</ul>
												<div class="py-1">
													<a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
												</div>
											</div>
											<button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
												<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
													<path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
												</svg>
												Filter
												<svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
													<path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
												</svg>
											</button>
										</div>
									</div>
								</div>
								<div class="overflow-x-auto">
									<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
										<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
															echo $category.' ';
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
								<nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
									<span class="text-sm font-normal text-gray-500 dark:text-gray-400">
										Showing
										<span class="font-semibold text-gray-900 dark:text-white">1-10</span>
										of
										<span class="font-semibold text-gray-900 dark:text-white">1000</span>
									</span>
									<ul class="inline-flex items-stretch -space-x-px">
										<li>
											<a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
												<span class="sr-only">Previous</span>
												<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
												</svg>
											</a>
										</li>
										<li>
											<a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
										</li>
										<li>
											<a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
										</li>
										<li>
											<a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
										</li>
										<li>
											<a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
										</li>
										<li>
											<a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
										</li>
										<li>
											<a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
												<span class="sr-only">Next</span>
												<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
												</svg>
											</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</section>
				</div>
			</div>
			</div>
		</div>
	</section>
	<?php endif; ?>


</div>

<?php
require_once 'includes/footer.php';
