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

				</div>
			</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php require_once 'includes/search-results.php'; ?>


</div>

<?php
require_once 'includes/footer.php';