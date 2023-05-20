<form action="#" class="flex-1 mt-8">
    <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Posez une question</h2>
    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        <div class="sm:col-span-2">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sujet ..." required="">
        </div>
        <div class="sm:col-span-2">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea id="markdown-editor" data-preview-id="renderer" data-input-id="html-input" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ma question ..."></textarea>
        </div>

        <div class="sm:col-span-2">
            <div id="renderer" class="html-markdown-renderer" rows="8" class="block p-2.5 w-full text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="Your description here"></div>
            <input type="hidden" id="html-input" name="html-input">
        </div>
    </div>
    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
        Soumettre la question
    </button>

    <div id="editor-container"></div>
</form>
