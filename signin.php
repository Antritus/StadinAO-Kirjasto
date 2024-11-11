<div id="signin-screen" class="modal login-screen">

    <!-- Modal Content -->
    <form class="modal-content animate" method="post" action="build/signin.bld.php">
        <div class="imgcontainer">
            <img src="assets/logo.png" alt="Logo" class="avatar">
            <h1>Kirjaudu Sisään</h1>

            <?php

            if (isset($_GET["signin"])) {
                $error = "Sinua ei voitu kirjautua sisään";

                switch ($_GET["signin"]) {
                    case "field_empty":
                        echo "<div class='login-error'><h2>" . $error . "!</h2><p>Täytä pakolliset kohdat</p></div>";
                        break;
                    case "invalid_email";
                        echo "<div class='login-error'><h2>" . $error . "!</h2><p'>Annettu sähköposti on virheellinen</p></div>";
                        break;
                    case "invalid_email_or_password";
                        echo "<div class='login-error'><h2>" . $error . "!</h2><p>Sähköposti tai salasana on väärä!</p></div>";
                        break;
                    case "stmt_failure":
                        echo "<div class='login-error'><h2>" . $error . "!</h2><p>Järjestelmässä tapahtui virhe. Koita uudelleen</p></div>";
                        break;
                    case "true":
                        break;
                    case "none";
                        echo "<script>window.location.replace('" . siteURL("index") . "');</script>";
                        break;
                    default:
                        echo "<div class='login-error'><h2>" . $error . "!</h2><p>Järjestelmässä tapahtui virhe. Koodi=" . $_GET["signin"] . "</p></div>";
                        break;
                }
            }
            ?>
        </div>

        <div class="container">
            <label for="email"><b>käyttäjätunnus</b></label>
            <input type="text" placeholder="käyttäjätunnus" name="email" required>

            <label for="password"><b>Salasana</b></label>
            <input type="password" placeholder="Salasana" name="pswd" required>

            <label>
                <input type="checkbox" checked="checked" name="remember"> Muista Minut
            </label>
            <button type="submit" name="submit">Kirjaudu</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearLoginSignup()" class="cancelbtn">Cancel</button>
            <span class="psw" style="margin-left: 0.5%">Unohditko <span onclick="signinResetPassword()" class="selectable">salasanasi? </span></span>
            <span class="psw"> Haluatko luoda <span onclick="signup()" class="selectable">käyttäjän?</span></span>
        </div>
    </form>
</div>