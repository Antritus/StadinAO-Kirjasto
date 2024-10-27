<div id="signup-screen" class="modal login-screen">
    <form class="modal-content animate" method="post" action="build/signup.bld.php">
        <div class="imgcontainer">
            <img src="assets/logo.png" alt="Logo" class="avatar">
            <h3>Luo Käyttäjä</h3>
        </div>

        <div class="container" style="margin-left:">
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-right: 1%">
                    <label for="name"><b>Etunimi</b></label>
                    <input type="text" placeholder="Etunimi..." name="name" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="sname"><b>Sukunimi</b></label>
                    <input type="text" placeholder="Sukunimi..." name="sname" required>
                </div>
            </div>
            <div style="display: inline" class="address-container">
                <div style="float: left; width: 39%; margin-right: 1%">
                    <label for="address"><b>Osoite</b></label>
                    <input type="text" placeholder="Osoite..." name="address" required>
                </div>
                <div style="float: left; width: 29.5%; margin-right: 1%">
                    <label for="postcode"><b>Postinumero</b></label>
                    <input type="text" placeholder="Postinumero..." name="postcode" required>
                </div>
                <div style="float: left; width: 29.5%;">
                    <label for="postarea"><b>Postitoimialue</b></label>
                    <select id="country" name="postarea">
                        <option value="Afghanistan">Espoo</option>
                        <option value="Afghanistan" selected>Helsinki</option>
                        <option value="Afghanistan">Vantaa</option>
                    </select>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 64.5%; margin-left: 1px">
                    <label for="email"><b>Sähköposti</b></label>
                    <input type="email" placeholder="Sähköposti..." name="email" required>
                </div>
                <div style="float: right; width: 34.5%;">
                    <label for="birthdate"><b>Syntymäaika</b></label>
                    <input type="date" min="<?php echo (date("Y")-100) . "-" . (date("m-d"));?>" max="<?php echo date("Y-m-d");?>" name="birthdate" required>
                </div>
            </div>
            <div style="display: inline">
                <div style="float: left; width: 49.5%; margin-left: 1px">
                    <label for="pswdRepeat"><b>Salasana</b></label>
                    <input type="password" placeholder="Salasana" name="pswd" required>
                </div>
                <div style="float: right; width: 49.5%;">
                    <label for="pswdR"><b>Salasana Uudelleen</b></label>
                    <input type="password" placeholder="Salasana" name="pswdR" required>
                </div>
            </div>
            <button type="submit">Luo Käyttäjä</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Muista Minut
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="clearLoginSignup()" class="cancelbtn">Cancel</button>
            <span class="psw">Haluatko <span onclick="signin()" class="selectable">kirjautua sisään?</span></span>
        </div>
    </form>
</div>
