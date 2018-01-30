<?php
if(isset($_GET['logout'])){
    foreach($_SESSION as $sesskey=>$sessitem){
        unset($_SESSION[$sesskey]); //Törli a munkamenet változókat
    }
    session_destroy(); //Megsemmisíti a munkamenetet
}

function checkCaptcha($text){ //Ellenörzi a kódot
    if(isset($_SESSION['code'])){
        if($_SESSION['code'] == $text){ //Ha létezik kód, és egyezik az átadottal, a kód helyes
            return true;
        }
    }
    return false; //Minden más esetben nem
}

function getCategoryName($id){ //Visszaadja a neki átadott ID-jű kategória nevét
    global $con;
    $sql = "SELECT category_name FROM categories WHERE category_id = '".$id."' LIMIT 1";
    $query = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($query);
    return $data['category_name'];
}

function getArticleName($id){ //Visszaadja a neki átadott ID-jű cikk nevét
    global $con;
    $sql = "SELECT article_name FROM articles WHERE article_id = '".$id."' LIMIT 1";
    $query = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($query);
    return $data['article_name'];
}

function showCategoriesSelect($num = "choose"){ //Megjeleníti a legördülő menüt a kategóriákkal
    global $con;
    echo '<select name="category"><option value="choose" '.($num == "choose" ? "selected" : "").'>Válassz</option>';
    $sql = "SELECT * FROM categories ORDER BY category_id ASC;";
    $query = mysqli_query($con,$sql);
    while($data=mysqli_fetch_assoc($query)){
        echo '<option value="'.$data['category_id'].'" '.($num == $data['category_id'] ? "selected" : "").' />'.$data['category_name'].'</option>';
    }
    echo "</select>";
}

function getUserEmail($id){ //Visszaadja a neki átadott ID-jű felhasználó E-mail-jét
    global $con;
    $sql = "SELECT email FROM users WHERE user_id = '".$id."' LIMIT 1";
    $query = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($query);
    return $data['email'];
}

function getStatusText($num){ //Visszaadja az adott állapot szövegét
    switch($num){
        case 0: return "Elfogadásra vár"; break;
        case 1: return "Munka folyamatban"; break;
        case 2: return "Munka befejezve"; break;
        case 3: return "Megbeszélésre vár"; break;
    }
}

function showStatusSelect($num = 0){ //Megjeleníti a legördülő menüt az állapotokkal
    echo '<select name="status">';
    for($i = 0; $i < 4; $i++) {
        echo '<option value="' . $i . '" ' . (($num == $i) ? "selected" : "") . '>' . getStatusText($i) . '</option>';
    }
    echo '</select>';
}

function reduceAmmount($order){ //Ellenörzi, és levonja a rendelt mennyiséget a raktárból
    global $con;
    $sql = "SELECT * FROM orders WHERE order_id = '".$order."'";
    $query = mysqli_query($con,$sql);
    $orderdata = mysqli_fetch_assoc($query); //Lekéri a rendelés adatait

    $sql = "SELECT * FROM articles WHERE article_id = '".$orderdata['article_id']."'";
    $query = mysqli_query($con,$sql);
    $articledata = mysqli_fetch_assoc($query); //Lekéri a cikk adatait

    if($orderdata['article_ammount'] > $articledata['article_ammount']){
        return false; //Ha többet rendelünk, mint amennyi van raktáron, hibát dob
    }else{
        $ammount = $articledata['article_ammount']-$orderdata['article_ammount'];
        $sql = "UPDATE articles SET article_ammount = '".$ammount."' WHERE article_id = '".$orderdata['article_id']."'";
        $query = mysqli_query($con,$sql); //Ha nem, akkor levonja a raktárból a rendelt mennyiséget
        return $query;
    }
}
?>