<?php
include ('haberleroop.php');
include ('../includes/header.php');
include ('../includes/navbaradmin.php');
$haberObj = new Haberler();

// Güncellenecek kayıtları getirir.
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $haber_id = (int)$_GET['id'];
    $haber = $haberObj->haberSec($haber_id);
    if (!$haber) {
        die('Geçersiz haber ID');
    }
} else {
    die('Geçerli bir haber ID giriniz.');
}

// Güncellenen kayıtları kaydeder.
// Güncellenen kayıtları kaydeder.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verileri kontrol edin ve güvenli hale getirin
    $haberData = [
        'kategori_id' => (int)$_POST['kategoriid'],
        'haber_baslik' => filter_var($_POST['haberbaslik'], FILTER_SANITIZE_STRING),
        'haber_icerik' => filter_var($_POST['habericerik'], FILTER_SANITIZE_STRING),
        'haber_id' => (int)$_POST['id']
    ];

    // CSRF token kontrolü
    if (!isset($_POST['token']) || $_POST['token']!= $_SESSION['token']) {
        die('CSRF saldırı tespit edildi');
    }

    // Validation
    if (empty($haberData['haber_baslik']) || empty($haberData['haber_icerik'])) {
        die('Haber başlığı ve içeriği boş olamaz');
    }

    // Haber ID'yi doğru şekilde geçirin
    if (!is_numeric($haber_id)) {
        die('Geçerli bir haber ID giriniz');
    }

    $haberObj->haberDuzenle($haber_id, $haberData); 
    header('Location: haberler.php');
}

// CSRF token oluşturma
$_SESSION['token'] = bin2hex(random_bytes(32));
?>

<form action="haberduzenle.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
    <div class="form-group mb-3">
        <label>Kategori</label>
        <select class="form-select" name="kategoriid">
            <?php
            $sorgu = "SELECT * FROM kategori_tablo";
            $veri = $haberObj->baglanti->query($sorgu);
            while ($kayit = $veri->fetch_assoc()) {
                if ($haber['kategori_id'] == $kayit['kategori_id']) {
                    echo "<option selected value='". $kayit['kategori_id']. "'>".
                        $kayit['kategori_adi']. "</option>";
                } else {
                    echo "<option value='". $kayit['kategori_id']. "'>".
                        $kayit['kategori_adi']. "</option>";
                }
            }
           ?>
        </select>
    </div>
    <div class="form-group mb-3">
        <label>Haber Başlık</label>
        <input type="text" class="form-control" name="haberbaslik" value="<?php echo htmlspecialchars($haber['haber_baslik']);?>">
    </div>
    <div class="form-group mb-3">
        <label>Haber İçerik</label>
        <textarea class="form-control" name="habericerik" rows="10" >
          <?php echo htmlspecialchars($haber['haber_icerik']);?>
        </textarea>
    </div>
    <input type="hidden" name="id" value="<?php echo $haber['haber_id'];?>">
    <input type="submit" class="btn btn-primary" value="Güncelle">
</form>