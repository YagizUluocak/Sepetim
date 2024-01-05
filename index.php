<?php
require_once('admin/classes/db.class.php');
include "admin/classes/functions.class.php";
$Urun = new Urun();
$urunGetir = $Urun->urunGetir();
if(isset($_GET["urun_id"]))
{
    $urun_id = $_GET["urun_id"];
    $urun = new Urun();
    $sepetEkle = $Urun->sepetEkle($urun_id);
}
$Urun2 = new Urun();
$sepetGetir = $Urun2->sepetGetir();
?>



<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepet Uygulaması</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Kendi CSS dosyanızı eklemek için -->
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Ürünler</h1>
        <div class="row">
            <!-- Ürünlerin Listeleneceği Bölüm -->
            <div class="col-md-8">
                <?php
                foreach($urunGetir as $urun)
                {
                    ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $urun->urun_adi?></h5>
                                <p class="card-text"><?php echo $urun->urun_aciklama?></p>
                                <fa-th-large class="text-muted" style="display: block;"><?php echo $urun->urun_fiyat ?> ₺</fa-th-large>
                                <form method="POST">
                                    <a href="index.php?urun_id=<?php echo $urun->urun_id?>" class="btn btn-primary" name ="submit">Sepete Ekle</a>
                                </form>
                            </div>
                        </div>
                    <?php
                }
                ?>

                
                <!-- Diğer ürün kartları buraya eklenebilir -->
            </div>
            <!-- Sepet Bölümü -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sepetiniz</h5>
                        <!-- Sepet içeriği buraya gelecek -->
                        <ul class="list-group">
                            <?php
                            foreach($sepetGetir as $sepet)
                            {
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h5><?php echo $sepet->urun_adi?></h5>
                                        <p><?php echo $sepet->urun_aciklama?></p>
                                        <p><?php echo $sepet->urun_fiyat?></p>
                                        <span class="badge badge-primary badge-pill"><?php echo $sepet->adet?></span>
                                    </li>
                                <?php
                            }
                            ?>

                        </ul>
                        <button class="btn btn-success mt-3">Satın Al</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS ve diğer gerekli kütüphaneler -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Kendi JavaScript dosyanızı eklemek için -->
    <script src="scripts.js"></script>
</body>

</html>
