function submenus(){
    document.addEventListener("DOMContentLoaded", function() {
        let currentOpenMenu = null;
        let currentParent = null;

        // Attach click event listener to all parent elements that have a submenu
        document.querySelectorAll(".menu-left, .menu-right").forEach(parent => {
            const submenu = parent.querySelector(".submenu");
            const openStatusIcon = parent.querySelector(".open-status i"); // Get the icon element
            if (!submenu) return; // Skip if there is no submenu

            parent.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent click from propagating to the window

                // Close the currently open submenu, if there is one
                if (currentOpenMenu && currentOpenMenu !== submenu) {
                    currentOpenMenu.style.display = "none";
                    currentParent.classList.remove("select-submenu");
                    const previousIcon = currentParent.querySelector(".open-status i");
                    if (previousIcon) {
                        previousIcon.classList.remove("fa-caret-down");
                        previousIcon.classList.add("fa-caret-right");
                    }
                }

                // Toggle visibility of the clicked submenu
                if (submenu.style.display === "block") {
                    submenu.style.display = "none";
                    parent.classList.remove("select-submenu");
                    if (openStatusIcon) {
                        openStatusIcon.classList.remove("fa-caret-down");
                        openStatusIcon.classList.add("fa-caret-right");
                    }
                    currentOpenMenu = null;
                    currentParent = null;
                } else {
                    submenu.style.display = "block";
                    parent.classList.add("select-submenu");
                    if (openStatusIcon) {
                        openStatusIcon.classList.remove("fa-caret-right");
                        openStatusIcon.classList.add("fa-caret-down");
                    }
                    currentOpenMenu = submenu;
                    currentParent = parent;
                }
            });
        });

        // Close the submenu if the user clicks outside of it
        window.addEventListener("click", function() {
            if (currentOpenMenu) {
                currentOpenMenu.style.display = "none";
                currentParent.classList.remove("select-submenu");
                const previousIcon = currentParent.querySelector(".open-status i");
                if (previousIcon) {
                    previousIcon.classList.remove("fa-caret-down");
                    previousIcon.classList.add("fa-caret-right");
                }
                currentOpenMenu = null;
                currentParent = null;
            }
        });
    });


}