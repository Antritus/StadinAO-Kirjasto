
function openBookAdd(){
    $("#add-book").show();
}
function closeBookAdd(){
    $("#add-book").hide();
}
function openBookDelete(isbn, name, author, description, language, publisher, published) {
    $("#book-delete").show();
    $("#delete-book-name").val(name);
    $("#delete-isbn").val(isbn);
    $("#delete-author").val(author);
    $("#delete-publisher").val(publisher);
    $("#delete-published").val(published);
    $("#delete-language").val(language);
    $("#delete-description").val(description);
}
function closeBookDelete(){
    $("#book-delete").hide();
}

$(document).ready(function() {
    closeBookDelete();
    closeBookAdd();

    $("#add-book-btn").click(function() {
        openBookAdd();
    });

    $(".modal").on("click", function() {
        closeBookAdd();
        closeBookDelete();
    });

    $(".modal-content").on("click", function(event) {
        event.stopPropagation();
    });
});
