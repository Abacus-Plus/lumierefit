let isPageLoading = false;

function togglePageLoading(show) {
    if (show) {
        isPageLoading = true;
        const loader = document.createElement('div');
        loader.className = 'page-loading';
        loader.innerHTML = '<div class="spinner"></div>';
        document.body.appendChild(loader);
        document.body.style.cursor = 'wait';
    } else {
        isPageLoading = false;
        const loader = document.querySelector('.page-loading');
        if (loader) {
            loader.remove();
        }
        document.body.style.cursor = 'default';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var filterToggle = document.querySelector('.show-hide-filters');
    var filterContainer = document.querySelector('.new-products__filter');
    var overlay = document.querySelector('.overlay2');
    var sortOptions = document.querySelectorAll('.sort-option');
    var categoryOptions = document.querySelectorAll('.category-option');
    var colorOptions = document.querySelectorAll('.color-option');
    var sizeOptions = document.querySelectorAll('.size-option');
    var applyFiltersBtn = document.getElementById('apply-filters');

    // Define currentGender based on URL parameter
    var currentUrl = new URL(window.location.href);
    var categoriesParam = currentUrl.searchParams.get('categories');
    var currentGender = categoriesParam ? categoriesParam.split(',')[0] : '';

    // Initialize filters if needed
    if (window.innerWidth <= 599) {
        filterContainer.classList.remove('show-filters');
        filterToggle.querySelector('span').textContent = 'Prikaži filtere';
    }

    filterToggle.addEventListener('click', function () {
        filterContainer.classList.toggle('show-filters');
        var isShowing = filterContainer.classList.contains('show-filters');
        filterToggle.querySelector('span').textContent = isShowing ? 'Sakrij filtere' : 'Prikaži filtere';
        if (window.innerWidth <= 599) {
            // Show or hide the overlay
            if (isShowing) {
                overlay.style.display = 'block';
                $('body').addClass('no-scroll');
            } else {
                overlay.style.display = 'none';
                $('body').removeClass('no-scroll');
            }
        }
    });

    // Prevent clicks on the overlay from closing the filters
    overlay.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    function collectSelectedFilters() {
        var selectedSort = Array.from(sortOptions).find(option => option.checked)?.value || '';
        var selectedCategories = Array.from(categoryOptions).filter(option => option.checked).map(option => option.value);
        var selectedColors = Array.from(colorOptions).filter(option => option.checked).map(option => option.value.split(',')).flat();
        var selectedSizes = Array.from(sizeOptions).filter(option => option.checked).map(option => option.value);

        return {
            selectedSort,
            selectedCategories,
            selectedColors,
            selectedSizes
        };
    }

    function applyFilters() {
        var filters = collectSelectedFilters();
        var categories = [currentGender];

        // Add selected categories
        if (filters.selectedCategories.length > 0) {
            categories = categories.concat(filters.selectedCategories);
        }

        // Update the URL parameters
        currentUrl.searchParams.set('categories', categories.join(','));

        if (filters.selectedColors.length > 0) {
            currentUrl.searchParams.set('colors', filters.selectedColors.join(','));
        } else {
            currentUrl.searchParams.delete('colors');
        }

        if (filters.selectedSizes.length > 0) {
            currentUrl.searchParams.set('sizes', filters.selectedSizes.join(','));
        } else {
            currentUrl.searchParams.delete('sizes');
        }

        if (filters.selectedSort) {
            currentUrl.searchParams.set('sort_by', filters.selectedSort);
        } else {
            currentUrl.searchParams.delete('sort_by');
        }

        // Navigate to the updated URL
        window.location.href = currentUrl.toString();
    }


    applyFiltersBtn.addEventListener('click', function () {
        applyFilters();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const targetDiv = document.querySelector('.new-products__filter');
    if (!targetDiv) return;

    if (window.innerWidth <= 599) {
        // Apply the transition after the page loads
        setTimeout(function () {
            targetDiv.style.transition = 'opacity 0.5s ease'; // Smooth transition
            targetDiv.style.opacity = 1;
        }, 500); // Delay of 1 second
    }
});

document.querySelectorAll('.color-label').forEach(label => {
    label.addEventListener('click', function () {
        const checkbox = this.querySelector('.color-option');
        checkbox.checked = !checkbox.checked; // Toggle the checkbox state

        if (checkbox.checked) {
            this.classList.add('checked'); // Add checked class
        } else {
            this.classList.remove('checked'); // Remove checked class
        }

        // Optional: Update the display of the spans based on the checkbox state
        const firstSpan = this.querySelector('span:first-child');
        const secondSpan = this.querySelector('span:nth-child(2)');
        firstSpan.style.display = checkbox.checked ? 'none' : 'block';
        secondSpan.style.display = checkbox.checked ? 'block' : 'none';
    });
});

function updateURLParameter(url, param, paramVal) {
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

// Update pagination links to maintain filters
document.querySelectorAll('.shop-pagination a').forEach(link => {
    link.addEventListener('click', function (e) {
        if (isPageLoading) return; // Prevent multiple clicks
        e.preventDefault();

        togglePageLoading(true);

        const currentUrl = window.location.href;
        const newUrl = updateURLParameter(currentUrl, 'paged', this.getAttribute('data-page'));

        // Scroll to top of products
        const productsSection = document.querySelector('.new-products');
        if (productsSection) {
            productsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Navigate after small delay to allow scroll animation
        setTimeout(() => {
            window.location.href = newUrl;
        }, 300);
    });
});