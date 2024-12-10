
function openWishAdd(){
    $("#add-wish").show();
}
function closeWishAdd(){
    $("#add-wish").hide();
}
function openWishDelete(isbn, name, author, description, language, publisher, published) {
    $("#wish-delete").show();
    $("#delete-book-name").val(name);
    $("#delete-isbn").val(isbn);
    $("#delete-author").val(author);
    $("#delete-publisher").val(publisher);
    $("#delete-published").val(published);
    $("#delete-language").val(language);
    $("#delete-description").val(description);
}
function closeWishDelete(){
    $("#wish-wish").hide();
}

$(document).ready(function() {
    closeWishAdd();
    closeWishDelete();

    $("#add-wish-btn").click(function() {
        openWishAdd();
    });

    $(".modal").on("click", function() {
        closeWishAdd();
        closeWishDelete();
    });

    $(".modal-content").on("click", function(event) {
        event.stopPropagation();
    });
});
