<?php
include ('baglanti2.php');
$sorgu = "DELETE FROM yazar_tablo WHERE yazar_id='" . $_GET["id"] . "'";
if ($baglanti2->query($sorgu)===true) {
header("location: yazarlar.php");
exit();
} else {
echo "Kayit silinemedi :" . $baglanti2->error;
}
$baglanti2->close();
?>
