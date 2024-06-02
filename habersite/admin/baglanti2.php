<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "haberler_db";
$baglanti2 = new mysqli($servername, $username, $password, $database);
if ($baglanti2 == false)
{
 die("Bağlantı Hatası:" . $baglanti2->connect_error);
}
?>