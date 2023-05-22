<?php

$categories = Database::get_categories();

?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const catDropdown = document.getElementById('categories-dropdown');
		const catRenderer = document.getElementById('categories-renderer');

		if(!catRenderer || !catDropdown) return;

		function updateRenderer() {
			catRenderer.style.display = "none";
			const catLis = Array.from(catDropdown.querySelectorAll('li input[type="checkbox"]')).map(el => el.checked ? {id:el.value, label:el.dataset.catLabel} : null).filter(el => el !== null);
			
			let content = '';
			for(const {label,id} of catLis) {
				content += '<span class="cat-container inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300" data-cat-id="' + id + '">\
				' + label + '\
				<button type="button" class="inline-flex items-center p-0.5 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" aria-label="Remove">\
				<svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>\
				<span class="sr-only">Retirer la catégorie</span>\
				</button>\
				</span>';
			}
			
			if(content) {
				catRenderer.style.display = 'flex'; 
			}

			catRenderer.innerHTML = content;
		}
		
		updateRenderer();
		catDropdown.addEventListener('click', updateRenderer);
		
		function handleRendererClick(e) {
			const catContainer = e.target.closest('.cat-container');
			if(!catContainer) return;
			
			const catId = catContainer.dataset.catId;
			catContainer.remove();
			const catCheckbox = Array.from(catDropdown.querySelectorAll('li input[type="checkbox"]')).find(el => el.value === catId);
			catCheckbox.checked = false;
		}

		catRenderer.addEventListener('click', handleRendererClick);
	})
</script>

<form action="#" class="flex-1 mt-8">
	<h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Posez une question</h2>
	<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
		<div class="sm:col-span-2">
			<label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
			<input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sujet ..." required="">
		</div>

		<!-- markdown editor -->
		<div class="sm:col-span-2">
			<label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
			<textarea id="markdown-editor" data-preview-id="renderer" data-input-id="html-input" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ma question ..."></textarea>
		</div>
		<div class="sm:col-span-2">
			<div id="renderer" class="html-markdown-renderer" rows="8" class="block p-2.5 w-full text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="Your description here"></div>
			<input type="hidden" id="html-input" name="html-input">
		</div>
		
		
		<!-- categories input -->
		<div id="categories-renderer" class="sm:col-span-2 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg flex w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></div>
		<div class="sm:col-span-2">
			<button id="dropdownCheckboxButton" data-dropdown-toggle="categories-dropdown" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium inline-flex items-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">Catégories <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>

			<div id="categories-dropdown" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-md dark:bg-gray-700 dark:divide-gray-600">
				<ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
					<?php

					$i = 0;
					foreach ( $categories as $category ) {
						$name = 'checkbox-item-' . strval( $i );
						?>
							<li>
								<div class="flex items-center">
									<input id="<?php echo htmlentities( $name ); ?>" name="<?php echo htmlentities( $name ); ?>" type="checkbox" value="<?php echo htmlentities( $category['id'] ); ?>" data-cat-label='<?php echo ucfirst( htmlentities( $category['label'] ) ); ?>' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
									<label for="<?php echo htmlentities( $name ); ?>" class="flex-1 ml-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-300"><?php echo ucfirst( htmlentities( $category['label'] ) ); ?></label>
								</div>
							</li>
						<?php
						$i++;
					}

					?>
				</ul>
			</div>
		</div>

	</div>
	<button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
		Soumettre la question
	</button>

	<div id="editor-container"></div>
</form>
