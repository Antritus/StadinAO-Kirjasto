var signinElement = document.getElementById('signup-screen');
var signinPasswordResetElement = document.getElementById('signin-password-reset-screen');
var signupElement = document.getElementById('signin-screen');

function signin() {
    clearLoginSignup().then(r => signinElement.style.display = "block");
}
function signup() {
    clearLoginSignup().then(r => signupElement.style.display = "block");
}
function signinResetPassword(){
    clearLoginSignup().then(r => signinPasswordResetElement.style.display = "block");
}

async function clearLoginSignup() {
    await fetchSigninElements();
    signupElement.style.display = "none";
    signinElement.style.display = "none";
    signinPasswordResetElement.style.display = "none";
}

function fetchSigninElements() {
    if (signupElement == null)
        signupElement = document.getElementById('signup-screen');
    if (signinPasswordResetElement == null)
        signinPasswordResetElement = document.getElementById('signin-password-reset-screen');
    if (signinElement == null)
        signinElement = document.getElementById('signin-screen');

}
/*

function addAddressElement(){
    for (var i = 0; i < 5; i++){
        var element = document.getElementById(`address${i}`);
        if (element == null)
            element = document.createElement("input");
            element.setAttribute("type", "text");
            element.setAttribute("")
        }
    }
}

 */
window.onclick = function(event) {
    fetchSigninElements();
    if (event.target == signinElement
        || event.target == signupElement
        || event.target == signinPasswordResetElement) {
        clearLoginSignup();
    }
}
