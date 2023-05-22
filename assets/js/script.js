function initDarkMode() {
  var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
  var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

  // Change the icons inside the button based on previous settings
  if (
    localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) &&
      window.matchMedia("(prefers-color-scheme: dark)").matches)
  ) {
    themeToggleLightIcon.classList.remove("hidden");
  } else {
    themeToggleDarkIcon.classList.remove("hidden");
  }

  var themeToggleBtn = document.getElementById("theme-toggle");

  themeToggleBtn.addEventListener("click", function () {
    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle("hidden");
    themeToggleLightIcon.classList.toggle("hidden");

    // if set via local storage previously
    if (localStorage.getItem("color-theme")) {
      if (localStorage.getItem("color-theme") === "light") {
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
      } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
      }

      // if NOT set via local storage previously
    } else {
      if (document.documentElement.classList.contains("dark")) {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
      } else {
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
      }
    }
  });
}

function initSearchDropdown() {
  if (!document.querySelector(".search-hidden-genre")) return;

  document.addEventListener("click", function (event) {
    let catEl = event.target.closest(
      ".search-cat-dropdown-container .dropdown-cat-search > ul > li"
    );
    if (!catEl) return;

    const catDropdownContainer = catEl.closest(
      ".search-cat-dropdown-container"
    );
    const hiddenInput = catDropdownContainer.querySelector(
      ".search-hidden-genre"
    );
    const buttonText = catDropdownContainer.querySelector(
      ".dropdown-cat-value"
    );
    const dropdown = catDropdownContainer.querySelector(".dropdown-cat-search");

    dropdown.classList.add("hidden");
    dropdown.classList.remove("block");
    const cat = catEl.dataset.cat;
    buttonText.innerHTML = cat || "Toutes catégories";
    hiddenInput.value = cat;
  });
}

function initCategoriesSelector() {
  const catDropdown = document.getElementById("categories-dropdown");
  const catRenderer = document.getElementById("categories-renderer");

  if (!catRenderer || !catDropdown) return;

  function updateRenderer() {
    catRenderer.style.display = "none";
    const catLis = Array.from(
      catDropdown.querySelectorAll('li input[type="checkbox"]')
    )
      .map((el) =>
        el.checked ? { id: el.value, label: el.dataset.catLabel } : null
      )
      .filter((el) => el !== null);

    let content = "";
    for (const { label, id } of catLis) {
      content +=
        '<span class="cat-container inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300" data-cat-id="' +
        id +
        '">\
			' +
        label +
        '\
			<button type="button" class="inline-flex items-center p-0.5 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" aria-label="Remove">\
				<svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>\
				<span class="sr-only">Retirer la catégorie</span>\
			</button>\
		</span>';
    }

    if (content) {
      catRenderer.style.display = "flex";
    }

    catRenderer.innerHTML = content;
  }

  updateRenderer();
  catDropdown.addEventListener("click", updateRenderer);

  function handleRendererClick(e) {
    const catContainer = e.target.closest(".cat-container");
    if (!catContainer) return;

    const catId = catContainer.dataset.catId;
    catContainer.remove();
    const catCheckbox = Array.from(
      catDropdown.querySelectorAll('li input[type="checkbox"]')
    ).find((el) => el.value === catId);
    catCheckbox.checked = false;

    if (
      Array.from(catDropdown.querySelectorAll('li input[type="checkbox"]'))
        .map((el) => el.checked)
        .filter((v) => v).length === 0
    ) {
      catRenderer.style.display = "none";
    }
  }

  catRenderer.addEventListener("click", handleRendererClick);
}

document.addEventListener("DOMContentLoaded", function () {
  initDarkMode();
  initSearchDropdown();
  initCategoriesSelector();
});
