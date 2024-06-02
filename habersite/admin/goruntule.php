<?php
include('haberleroop.php');
include('../includes/header.php');
include('../includes/navbaradmin.php');

// Haberleri gösterme
$haberObj = new Haberler();
$haberler = $haberObj->haberListe();

// Yazarları gösterme
$sorgu_yazar = "SELECT * FROM yazar_tablo";
$veri_yazar = $haberObj->baglanti->query($sorgu_yazar);
$yazarlar = array();
while ($kayit_yazar = $veri_yazar->fetch_assoc()) {
    $yazarlar[] = $kayit_yazar;
}

// Kategorileri gösterme
$sorgu_kategori = "SELECT * FROM kategori_tablo";
$veri_kategori = $haberObj->baglanti->query($sorgu_kategori);
$kategoriler = array();
while ($kayit_kategori = $veri_kategori->fetch_assoc()) {
    $kategoriler[] = $kayit_kategori;
}
?>

<div class="container mt-4">
    <h1>Haberler, Yazarlar ve Kategoriler</h1>
    <h2>Haberler</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Haber Id</th>
                <th scope="col">Haber Başlık</th>
                <th scope="col">Haber Tarihi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($haberler as $haber) : ?>
                <tr>
                    <td><?= $haber['haber_id'] ?></td>
                    <td><?= $haber['haber_baslik'] ?></td>
                    <td><?= $haber['haber_tarih'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Yazarlar</h2>
    <ul>
        <?php foreach ($yazarlar as $yazar) : ?>
            <li><?= $yazar['yazar_adsoyad'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Kategoriler</h2>
    <ul>
        <?php foreach ($kategoriler as $kategori) : ?>
            <li><?= $kategori['kategori_adi'] ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include('../includes/footer.php'); ?>
