<?php
if(isset($_GET['activate'])){ //Ha van activate GET paraméter
    $sql = "SELECT * FROM users WHERE activation = '".$_GET['activate']."'";
    $query = mysqli_query($con,$sql);
    if(mysqli_num_rows($query) > 0){ //Ha létezik ilyen aktiváció
        $data = mysqli_fetch_assoc($query);
        $sql = "UPDATE users SET activation = '' WHERE user_id = '".$data['user_id']."'"; //Törli az aktivációs számot, ezzel aktiválja a felhasználót
        $query = mysqli_query($con,$sql);
        $msg = "Aktiváció sikeres! Mostmár bejelentkezhetsz!";
    }
}

if(isset($_POST['emailoruser'])) { //Ha van küldve adat
    $sql = "SELECT * FROM users WHERE username = '" . $_POST['emailoruser'] . "' OR email = '" . $_POST['emailoruser'] . "' "; //Lekéri azokat a felhasználókat, ahol egyezik az email vagy a felhasználónév
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) > 0) { //Ha van találat
        while ($data = mysqli_fetch_assoc($query)) {
            if (empty($data['activation'])) { //Ha üres az aktivációs kód
                if (md5($_POST['password']) == $data['password']) { //Ha a jelszó megfelel
                    $_SESSION['loggedin'] = true; //Beállítja a munkamenet változókat
                    $_SESSION['userid'] = $data['user_id'];
                    if ($data['isadmin']) { //Ha adminisztrátor
                        $_SESSION['isadmin'] = true; //Beállítja azt is
                    }
                    break;
                }
            } else {
                $notactive = true; //Ha nem üres az aktivációs kód, nem enged bejelentkezni
            }
        }
    }
    if (!isset($_SESSION['loggedin'])) {
        $msg = 'Hibás felhasználónév vagy jelszó!';
        $error = true;
    }

    if (isset($notactive)) {
        $msg = 'Felhasználó még nincs aktiválva. Ellenőrizd az Email fiókod az aktivációhoz!';
        $error = true;
    }
}
    if (!isset($_SESSION['loggedin'])) {
        echo (isset($msg) ? '<h2 class="center'.(isset($error) ? ' red"' : '"') .'>'.$msg.'</h2>' : '');
        echo '
            <form method="post" action="?page=login" class="center">
                <p class="center">Email vagy Felhasználónév: <br><input type="text" name="emailoruser" /></p>
                <p class="center">Jelszó: <br><input type="password" name="password" /></p>
                <p class="center"><input type="submit" value="Bejelentkezés"></p>
                <a href="?page=register">Regisztráció</a>
            </form>'; //Alapesetben csak az űrlap jelenik meg

        ///////////////////////////////////////////////////////////////////

    }else{
        if(isset($_POST['passnew'])){ //Ha lett valami küldve
            $sql = "SELECT * FROM users WHERE user_id = '".$_SESSION['userid']."'";
            $query = mysqli_query($con,$sql);
            $data = mysqli_fetch_assoc($query);
            if(md5($_POST['passcurrent']) == $data['password']) { //Ellenörzi az aktuális jelszót
                $sql = "UPDATE users SET email = '".$_POST['email']."'"
                    .(!empty($_POST['passnew']) ? ", password = '".md5($_POST['passnew'])."'" : "" )
                    ." WHERE user_id = '".$_SESSION['userid']."'"; //Menti a változásokat
                $query = mysqli_query($con,$sql);
                echo "<h2 class='red'>Adatok módosítva!</h2>";
            }
        }
        $sql = "SELECT * FROM users WHERE user_id = '".$_SESSION['userid']."'";
        $query = mysqli_query($con,$sql);
        $data = mysqli_fetch_assoc($query);
        echo "<h1><a href='?logout=true'>Kijelentkezés</a></h1><hr>";
        echo "<h1>Felhasználói adatok</h1>";
        echo '<form method="post" action="?page=login">
             <p class="center">E-Mail: <br><input type="text" name="email" value="'.$data['email'].'" /></p>
             <p class="center">Új jelszó (ha váltanál): <br><input type="password" name="passnew" /> </p>
             <p class="center">Jelenlegi jelszó: <br><input type="password" name="passcurrent" /></p>
             <p class="center"><input type="submit" value="Küldés"/></p>
        </form><hr>';
        echo "<h1>Rendeléseim</h1>";
        echo '<table width="100%" border="1" cellpadding="5" cellspacing="0" class="center">
        <tr>
        <th>Rendelés azonosító</th>
        <th>Rendelés leírás</th>
        <th>Mellékletek</th>
        <th>Darabszám</th>
        <th>Cikk neve</th>
        <th>Állapot</th>
        </tr>';
        $sql = "SELECT * FROM orders WHERE user_id = '".$_SESSION['userid']."';";
        $query = mysqli_query($con,$sql);
        while($data = mysqli_fetch_assoc($query)){
            echo '<tr>
                <td>'.$data['order_id'].'</td>
                <td>'.$data['order_description'].'</td><td>';
                if(!empty($data['order_misc_files'])) {
                    foreach (explode("::", $data['order_misc_files']) as $file) { //Mellékletek megjelenítése
                        echo '<a href="orders/' . $file . '" target="_blank"><img src="orders/' . $file . '" width="100" /></a>';
                    }
                }
            echo '</td>
                <td>'.$data['article_ammount'].'</td>
                <td>'.getArticleName($data['article_id']).'</td>
                <td>'.getStatusText($data['order_status']).'</td>
                </tr>';
        }
        echo '</table><hr>';
    }
?>