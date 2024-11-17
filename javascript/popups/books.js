let bookAddElement = document.getElementById('add-book');
let bookDeleteElement = document.getElementById('book-delete');

function deleteBook(isbn, name, author, description, language, publisher, published) {
    clearDeleteBook();
    bookDeleteElement.style.display = "block";

    document.getElementById("delete-book-name").value = name;
    document.getElementById("delete-isbn").value = isbn;
    document.getElementById("delete-author").value = author;
    document.getElementById("delete-publisher").value = publisher;
    document.getElementById("delete-published").value = published;
    document.getElementById("delete-language").value = language;
    document.getElementById("delete-description").value = description;
}

function clearDeleteBook() {
    fetchDeleteElement();
    bookDeleteElement.style.display = "none";
}

function fetchDeleteElement() {
    if (bookDeleteElement == null)
        bookDeleteElement = document.getElementById('book-delete');
}

function addBook() {
    console.log("hi");
    fetchBookAdd();
    console.log("hi 2");
    bookAddElement.style.display = "block";
    console.log("hi 3");
}

function clearBookAdd() {
    fetchBookAdd();
    bookAddElement.style.display = "none";
}

function fetchBookAdd() {
    if (bookAddElement == null)
        bookAddElement = document.getElementById('add-book');
}
window.onclick = function(event) {
    console.log("Hi");
    fetchDeleteElement();
    fetchBookAdd();
    if (event.target == bookDeleteElement
        || event.target == bookAddElement
    ) {
        clearDeleteBook();
        clearBookAdd();
    }
}
