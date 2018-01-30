<h1>Rendelés</h1>
<?php
if(isset($_POST['description'])){ //Ha el lett küldve az űrlap
    $orderid = md5(time().mt_rand(0,99).mt_rand(0,99)); //Rendelés azonosító
    $error = false;
    for($i = 1; $i < 6; $i++){ //Ellenörzi a feltöltött fileokat
        if(!empty($_FILES['attachment'.$i]['name'])){
            $file_name = $_FILES['attachment'.$i]['name'];
            $file_tmp = $_FILES['attachment'.$i]['tmp_name'];
            $file_explode = explode('.', $file_name);
            $file_ext = strtolower(end($file_explode));
            $expensions = array("jpeg", "jpg", "png");
			$upfiles = array();
            if (in_array($file_ext, $expensions) === true) { //Ellenörzi a file kiterjesztését
                $newname = $_SESSION['userid'].'-'.$orderid.'-'.$i.".". $file_ext; //Új nevet ad a föltöltött filenak
                move_uploaded_file($file_tmp, "orders/" . $newname); //Menti a file-t
                $upfiles[] = $newname;
            } else {
                $error = true; //Ha valamelyik kiterjesztés nem jó, hibát jelez
            }
        }
    }
    if($error){ //Megnézi van-e valamilyen hiba
        foreach($upfiles as $file){ //Ha van, törli az összes filet
            unlink("orders/".$file);
        }
        $msg = "File tipus nem megfelelő!";
    }else{ //Ha nincs
        if(is_numeric($_POST['ammount'])) { //Megnézi, hogy a mennyiség szám-e
			if(!empty($upfiles)){ //Ha van feltöltött kép
				$upfiles = implode("::", $upfiles); //Egymás mellé rendezi a fileneveket, menti őket
			}else{
				$upfiles = ""; //Ha nincs kép, üres marad
			}
            $sql = "INSERT INTO orders VALUES ('" . $orderid . "','" . $_SESSION['userid'] . "','" . $_POST['description'] . "','" . $upfiles . "','".$_GET['order']."','" . $_POST['ammount'] . "','0','".time()."')";
            //Bepakolja az adatbázisba
            $query = mysqli_query($con,$sql);
            $msg = 'Rendelés sikeresen hozzáadva!<br><a href="?page=login">Rendelések megtekintése</a>';
        }else{
            $msg = "A megadott mennyiség nem szám";
            $error = true;
        }
    }
}
if(isset($_SESSION['loggedin'])){
    if(!isset($_GET['order'])) { //Ha nincs kiválasztva termék
        $sql = "SELECT * FROM categories"; //Lekéri az összes kategóriát
        $query = mysqli_query($con, $sql);
        echo '<center>';
        while ($data = mysqli_fetch_assoc($query)) { //Kategóriánként külön
            echo "<h1>" . $data['category_name'] . "</h1>"; //Kategória neve
            $sqlart = "SELECT * FROM articles WHERE category_id = '" . $data['category_id'] . "'"; //Lekéri az összes terméket a kategóriából
            $queryart = mysqli_query($con, $sqlart);
            while ($dataart = mysqli_fetch_assoc($queryart)) {
                echo '<div class="card"><a href="?page=order&order=' . $dataart['article_id'] . '"><img src="prods/' . $dataart['article_img'] . '" alt="' . $dataart['article_name'] . '" width="200" />
            <p>'.$dataart['article_name'].'</p></a></div>'; //Kiírkálja a termékeket egymás mellé
            }
            echo '<hr style="clear:both;" />';
        }
        echo '</center>';

    }else{ //Ha van kiválasztva termék

        $sql = "SELECT * FROM articles WHERE article_id = '".$_GET['order']."'"; //Lekéri a termék adatait
        $query = mysqli_query($con,$sql);
        $data = mysqli_fetch_assoc($query);
        if(isset($msg)) {
            echo '<h2 '.(($error == true) ? 'class="red"' : '').'>'.$msg.'</h2>
            <hr>';
        }
        echo "<h2>Kiválasztott cikk: ".getCategoryName($data['category_id'])." - ".$data['article_name']."</h2>";
        echo '<img src="prods/'.$data['article_img'].'" width="400" style="float:right; margin-right:100px;"/>';
        echo '<form method="post" action="?page=order&order='.$_GET['order'].'" enctype="multipart/form-data">
        <p>Rendelés leírása:<br>
        <textarea name="description"></textarea> </p>
        <p>Mennyiség <input type="text" name="ammount" /> - '.$data['article_ammount'].' van raktáron</p>
        <p>Mellékletek [jpg,jpeg,png]:</p>
        <p><input type="file" name="attachment1" /></p>
        <p><input type="file" name="attachment2" /></p>
        <p><input type="file" name="attachment3" /></p>
        <p><input type="file" name="attachment4" /></p>
        <p><input type="file" name="attachment5" /></p>
        <p><input type="submit" value="Küldés" /></p>
        </form>'; //űrlap meg a többi

    }
}else{
	echo '<p class="center"><a href="?page=login">Bejelentkezés szükséges</a></p>';
}
?>
