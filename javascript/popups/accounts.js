function openAccountAdd(){
    $("#account-add").show();
}
function closeAccountAdd(){
    $("#account-add").hide();
}
function openAccountDelete(id, email, accountName, name, surname, birthday, address, postcode, postArea) {
    $("#account-delete").show();
    $("#delete-id").val(id);
    $("#delete-email").val(name);
    $("#delete-acc-name").val(name);
    $("#delete-name").val(name);
    $("#delete-sname").val(surname);
    $("#delete-address").val(address);
    $("#delete-postcode").val(postcode);
    $("#delete-postarea").val(postArea);
    $("#delete-birthdate").val(birthday);
}
function closeAccountDelete(){
    $("#account-delete").hide();
}

$(document).ready(function() {
    closeAccountDelete();
    closeAccountAdd();

    $("#add-account-btn").click(function() {
        openAccountAdd();
    });

    $(".modal").on("click", function() {
        closeAccountAdd();
        closeAccountDelete();
    });

    $(".modal-content").on("click", function(event) {
        event.stopPropagation();
    });
});
