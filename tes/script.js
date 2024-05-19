function activatePage(page) {
    // Hide all content pages
    document.querySelectorAll('.content-page').forEach(pageElement => {
        pageElement.classList.add('hidden');
    });

    // Remove active class from all menu items
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });

    // Show the selected content page
    document.getElementById(`${page}-content`).classList.remove('hidden');

    // Add active class to the selected menu item
    document.getElementById(page).classList.add('active');
}
