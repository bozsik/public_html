

<?php
if(isset($_POST['username'])) {
    if(checkCaptcha($_POST['captcha'])) { //Ellenörzi a kódot
        $sql = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "' OR email ='" . $_POST['email'] . "'";
        $query = mysqli_query($con, $sql);
        if (mysqli_num_rows($query) > 0) {
            $error = true;
            $msg = "Email vagy felhasználónév foglalt!";
        } else {
            if ($_POST['password'] == $_POST['password2']) {
                $activation = md5(time() . $_POST['username'] . $_POST['email']); //Aktiváló kód

                $message = "Üdvözlet!\n\nValaki ezzel a címmel regisztrált az oldalunkra. Ha Te voltál, kattints az alábbi linkre az aktivációhoz!\n
            <a href=\"http://localhost/?page=login&activate=" . $activation . "\">http://localhost/?page=login&activate=" . $activation . "</a>"; //Email szövege

                $sql = "INSERT INTO users VALUES (null,'" . $_POST['username'] . "',
                '" . md5($_POST['password']) . "','" . $_POST['email'] . "','" . time() . "','false','" . $activation . "')";
                $query = mysqli_query($con, $sql);
                if ($query) {
                    @mail($_POST['email'], "Regisztráció", $message); //Email küldés ( @ = Nem jelez hibát)
                    $msg = 'Regisztráció sikeres!<br>Ellenőrizd az E-Mail fiókod az aktivációért!';
                    $success = true;
                } else {
                    $msg = 'Regisztráció sikertelen!<br/>' . mysqli_error($con) . '';
                }
            } else {
                $error = true;
                $msg = "A két jelszó nem egyezik!";
            }
        }
    }else{
        $error = true;
        $msg = "Az ellenörzőkód helytelen!";
    }
}
echo (isset($msg) ? '<h2 class="center'.(isset($error) ? ' red"' : '"') .'>'.$msg.'</h2>' : '');
if(!isset($success)) {
    echo '<form method = "post" action = "?page=register" class="center" >
    <p > Felhasználónév: <br ><input type = "text" name = "username" /></p >
    <p > Email: <br ><input type = "text" name = "email" /></p >
    <p > Jelszó: <br ><input type = "password" name = "password" /></p >
    <p > Jelszó mégegyszer: <br ><input type = "password" name = "password2" /></p >
    <p > Írd be a kódot: <img src="img/captcha.php" alt="captcha"><br><input type="text" name="captcha" /></p>
    <p ><input type = "submit" value = "Regisztráció" ></p >
</form >';
}
?>