<?php
include "config.php";
$sql = "SELECT * FROM users";
$query = mysqli_query($con,$sql);
echo '<table width="100%" border="1" style="text-align: center;">';
echo '<tr>';
echo '<th>Username</th><th>E-Mail</th><th>Admin</th><th>Activation</th>';
echo '</tr>';
while($data = mysqli_fetch_assoc($query)){
    echo '<tr>';
    echo '<td>'.$data['username'].'</td><td>'.$data['email'].'</td><td>'.$data['isadmin'].'</td><td><a href="index.php?page=login&activate='.$data['activation'].'">'.$data['activation'].'</a></td>';
    echo '</tr>';
}
echo '</table>';
?>