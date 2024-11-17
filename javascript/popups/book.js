let extendElement = document.getElementById('extend-book');
let borrowElement = document.getElementById('borrow-book');
let addElement = document.getElementById('add-book');
let returnElement = document.getElementById('return-book');

async function bookBorrow(ISBN, bookISBN, book) {
    await clearBorrow().then(r => borrowElement.style.display = "block");
    document.getElementById("borrow-book-name").value = book;
    document.getElementById("borrow-isbn").value = ISBN;
    document.getElementById("borrow-book-isbn").value = bookISBN;
}

async function clearBorrow() {
    await fetchBorrowElement();
    borrowElement.style.display = "none";
}

function fetchBorrowElement() {
    if (borrowElement == null)
        borrowElement = document.getElementById('borrow-book');
}

async function extend(ISBN, bookISBN, book, account) {
    await clearExtend().then(r => extendElement.style.display = "block");
    let isbnField = document.getElementById("extend-isbn");
    isbnField.value = ISBN;

    let isbnBookField = document.getElementById("extend-book-isbn");
    isbnBookField.value = bookISBN;

    let bookName = document.getElementById("extend-book-name");
    bookName.value = book;

    let accountField = document.getElementById("extend-account");
    accountField.value = account;
}

async function clearExtend() {
    await fetchExtendElement();
    extendElement.style.display = "none";
}

function fetchExtendElement() {
    if (extendElement == null)
        extendElement = document.getElementById('extend-book');
}

async function addBook(ISBN, bookName) {
    await clearAdd().then(r => addElement.style.display = "block");
    document.getElementById("add-isbn").value = ISBN;
    document.getElementById("add-book-name").value = bookName;
}

async function clearAdd() {
    await fetchAddElement();
    addElement.style.display = "none";
}

function fetchAddElement() {
    if (addElement == null)
        addElement = document.getElementById('add-book');
}

async function bookReturn(ISBN, bookISBN, name, account, lastReturnDate) {
    await clearReturn().then(r => returnElement.style.display = "block");
    document.getElementById("return-book-name").value = name;
    document.getElementById("return-account").value = account;
    document.getElementById("return-book-isbn").value = bookISBN;
    document.getElementById("return-isbn").value = ISBN;
    document.getElementById("return-return_date").valueAsDate = new Date(lastReturnDate);
}

async function clearReturn() {
    await fetchReturnElement();
    returnElement.style.display = "none";
}

function fetchReturnElement() {
    if (returnElement == null)
        returnElement = document.getElementById('return-book');
}

window.onclick = function(event) {
    fetchBorrowElement();
    fetchExtendElement();
    fetchReturnElement();
    fetchAddElement();
    if (event.target == extendElement
        || event.target == borrowElement
        || event.target == addElement
        || event.target == returnElement
    ) {
        clearBorrow();
        clearExtend();
        clearAdd();
        clearReturn()
    }

}

