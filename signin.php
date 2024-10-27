<div id="signin-screen" class="modal login-screen">

    <!-- Modal Content -->
    <form class="modal-content animate" method="post" action="build/signin.bld.php">
        <div class="imgcontainer">
            <img src="assets/logo.png" alt="Logo" class="avatar">
            <h3>Kirjaudu Sisään</h3>
        </div>

        <div class="container">
            <label for="email"><b>Sähköposti</b></label>
            <input type="email" placeholder="Sähköposti" name="email" required>

            <label for="password"><b>Salasana</b></label>
            <input type="password" placeholder="Salasana" name="password" required>

            <button type="submit">Kirjaudu</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Muista Minut
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearLoginSignup()" class="cancelbtn">Cancel</button>
            <span class="psw" style="margin-left: 0.5%">Unohditko <span onclick="signinResetPassword()" class="selectable">salasanasi? </span></span>
            <span class="psw"> Haluatko luoda <span onclick="signup()" class="selectable">käyttäjän?</span></span>
        </div>
    </form>
</div>