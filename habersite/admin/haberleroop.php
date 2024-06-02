<?php
class Haberler
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "haberler_db";
    public $baglanti;

    public function __construct()
    {
        $this->baglanti = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->baglanti->connect_error) {
            die("Hata:" . $this->baglanti->connect_error);
        }
        // Oturum başlatılmamışsa başlat
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Doğrudan bir yazar ID atayın
        $_SESSION['yazar_id'] = 4; // veya başka bir değer
    }

    public function haberListe()
    {
        $sorgu = "SELECT * FROM haber_tablo";
        $veri = $this->baglanti->query($sorgu);
        if ($veri->num_rows > 0) {
            $haberler = array();
            while ($kayit = $veri->fetch_assoc()) {
                $haberler[] = $kayit;
            }
            return $haberler;
        } else {
            return array(); // Boş dizi döndür
        }
    }
    
    public function haberEkle($post)
    {
        // $kategori_id, $haber_baslik ve $haber_icerik gibi diğer post değerlerini almak için gerekli kodları buraya ekleyin

        $kategori_id = $_POST['kategoriid'];
        $haber_baslik = $_POST['haberbaslik'];
        $haber_icerik = $_POST['habericerik'];
        $yazar_id = $_SESSION['yazar_id'];
        $sorgu = "INSERT INTO haber_tablo(kategori_id, haber_baslik, haber_icerik, yazar_id) VALUES ('$kategori_id', '$haber_baslik', '$haber_icerik', '$yazar_id')";
        $sonuc = $this->baglanti->query($sorgu);
        if ($sonuc === true) {
            header("Location: haberler.php");
            exit();
        } else {
            echo "Kayıt işlemi başarısız! " . $this->baglanti->error;
        }
    }
    public function haberSil($haber_id) {
    $sorgu = "DELETE FROM haber_tablo WHERE haber_id = '$haber_id'";
    $sonuc = $this->baglanti->query($sorgu);
    if ($sonuc === true) {
        header("Location: haberler.php");
        exit();
    } else {
        echo "Silme işlemi başarısız! " . $this->baglanti->error;
    }
}
public function haberSec($haber_id) {
    $sorgu = "SELECT * FROM haber_tablo WHERE haber_id = '$haber_id'";
    $veri = $this->baglanti->query($sorgu);
    if ($veri->num_rows > 0) {
        return $veri->fetch_assoc();
    } else {
        return null; // veya boş bir dizi döndürebilirsiniz
    }
    echo "Haber ID: " . $haber_id;
print_r($haber);
}
public function haberDuzenle($haber_id, $guncellenecek_alanlar) {
    // Güncellenecek alanları kontrol et
    if (empty($guncellenecek_alanlar) || !is_numeric($haber_id)) {
        return array('status' => 'error', 'message' => 'Geçerli bir haber ID giriniz');
    }

    // Güncelleme sorgusunu hazırla
    $sorgu = "UPDATE haber_tablo SET kategori_id = '" . $guncellenecek_alanlar['kategoriid'] . "', haber_baslik = '" . $guncellenecek_alanlar['haberbaslik'] . "', haber_icerik = '" . $guncellenecek_alanlar['habericerik'] . "', haber_resim = '" . $guncellenecek_alanlar['haberresim'] . "' WHERE haber_id = " . $haber_id;

    // Veritabanına güncelleme yap
    $this->baglanti->query($sorgu);
}
}

?>
