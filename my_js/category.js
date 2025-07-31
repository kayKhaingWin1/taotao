
document.addEventListener("DOMContentLoaded", function () {
    const categories = document.querySelectorAll(".category-item");
    const subcategoryContainer = document.getElementById("subcategory-container");
    const scrollContainer = document.querySelector(".category-scroll");
    const scrollLeftBtn = document.querySelector(".scroll-left");
    const scrollRightBtn = document.querySelector(".scroll-right");


    function loadSubcategories(categoryId) {
        fetch(`get_subcategories.php?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategoryContainer.innerHTML = "";

                data.forEach(sub => {
                    const card = document.createElement("div");
                    card.className = "subcategory-card text-center";
                    
                    card.innerHTML = `
                    <a href="product.php?category=${categoryId}&subcategory=${sub.id}" class="subcategory-link">
                    <img src="admin_taotao/uploads/${sub.image}" alt="${sub.name}">
                    <div class="subcategory-name">${sub.name}</div>
                    </a>`;

                    
                    subcategoryContainer.appendChild(card);
                });


                const viewAll = document.createElement("div");
                viewAll.className = "text-center mt-3";

                viewAll.innerHTML = `
                <a href="product.php?category=${categoryId}" class="view-all-link">
                    👁 View All
                </a>`;
                subcategoryContainer.appendChild(viewAll);
            })
            .catch(error => {
                console.error("Error loading subcategories:", error);
                subcategoryContainer.innerHTML = "<p class='text-danger'>Failed to load subcategories.</p>";
            });
    }


    categories.forEach((cat, index) => {
        cat.addEventListener("mouseenter", () => {
            categories.forEach(c => c.classList.remove("active"));
            cat.classList.add("active");
            const categoryId = cat.getAttribute("data-category");
            loadSubcategories(categoryId);
        });

        if (index === 0) {
            cat.classList.add("active");
            const defaultId = cat.getAttribute("data-category");
            loadSubcategories(defaultId);
        }
    });


    
    if (scrollContainer && scrollLeftBtn && scrollRightBtn) {
        scrollLeftBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: -500, behavior: "smooth" });
        });

        scrollRightBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: 500, behavior: "smooth" });
        });
    }
});






