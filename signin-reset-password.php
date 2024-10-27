<div id="signin-password-reset-screen" class="modal login-screen">
  <span onclick="document.getElementById('login-screen').style.display='none'"
        class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" method="post" action="build/signin-reset-password.bld.php">
        <div class="imgcontainer">
            <img src="assets/logo.png" alt="Logo" class="avatar">
            <h3>Vaihda salasanasi</h3>
            <p>Saat viestin sähköpostiin, jos löydämme tunnuksesi palvelimiltamme. Sähköpostissa on ohje salasanan vaihtoon.</p>
        </div>

        <div class="container">
            <label for="email"><b>Sähköposti</b></label>
            <input type="email" placeholder="Sähköposti" name="email" required>

            <button type="submit">Vaihda Salasana</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearLoginSignup()" class="cancelbtn">Cancel</button>
            <span class="psw">Haluatko <span onclick="signin()" class="selectable">kirjautua sisään?</span></span>
        </div>
    </form>
</div>