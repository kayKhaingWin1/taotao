let debounceTimer;

        function debounceSubmit() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 600);
        }

        function submitForm() {
            document.getElementById('filterForm').submit();
        }

        let lastScrollTop = 0;
        const filterBar = document.getElementById("filterBar");

        window.addEventListener("scroll", function() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScroll < lastScrollTop) {
                filterBar.classList.add("sticky-top");
            } else {
                filterBar.classList.remove("sticky-top");
            }
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });

        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const container = document.getElementById("active-filters");

            const ignoreKeys = ['search', 'category']; 
            const preservedKeys = ['category']; 

            let tagCount = 0;

            urlParams.forEach((val, key) => {
                if (val && !ignoreKeys.includes(key)) {
                    const tag = document.createElement("span");
                    tag.className = "badge bg-secondary px-3 py-2 me-1 d-flex align-items-center";

                    const select = document.querySelector(`[name="${key}"]`);
                    let displayText = val;
                    if (select) {
                        const selectedOption = select.querySelector(`option[value="${val}"]`);
                        if (selectedOption) {
                            displayText = selectedOption.textContent;
                        }
                    }

                    tag.innerHTML = `${displayText} <a href="${removeParam(key)}" class="text-white ms-2" style="text-decoration: none;">&times;</a>`;
                    container.appendChild(tag);
                    tagCount++;
                }
            });

            if (tagCount > 0) {
                const clear = document.createElement("a");
                clear.id = "clearAllBtn";
                clear.className = "btn btn-outline-secondary btn-sm ms-2";
                clear.href = buildClearAllLink();
                clear.textContent = "Clear All";
                container.appendChild(clear);
            }

           
            function removeParam(param) {
                const newParams = new URLSearchParams(window.location.search);
                newParams.delete(param);

            
                preservedKeys.forEach(key => {
                    if (urlParams.has(key)) {
                        newParams.set(key, urlParams.get(key));
                    }
                });

                return `${window.location.pathname}?${newParams.toString()}`;
            }

       
            function buildClearAllLink() {
                const newParams = new URLSearchParams();
                preservedKeys.forEach(key => {
                    if (urlParams.has(key)) {
                        newParams.set(key, urlParams.get(key));
                    }
                });
                return `${window.location.pathname}?${newParams.toString()}`;
            }
        });