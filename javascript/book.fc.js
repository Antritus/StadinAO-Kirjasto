var bookAddElement = document.getElementById('book-add');
function addBook() {
    clearBookAdd().then(r => bookAddElement.style.display = "block");
}

async function clearBookAdd() {
    await fetchBookElement();
    bookAddElement.style.display = "none";
}

function fetchBookElement() {
    if (bookAddElement == null)
        bookAddElement = document.getElementById('book-add');
}

window.onclick = function(event) {
    fetchBookElement();
    if (event.target == bookAddElement) {
        clearBookAdd();
    }
}
