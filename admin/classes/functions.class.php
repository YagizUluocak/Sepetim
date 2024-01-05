<?php
class Veri extends Db
{
    private $tablo_Adi;
    private $tablo_id_alan;
    private $tablo_id;
    private $sorgu;
    public function veriGetir($tablo_adi, $sorgu)
    {
        $query = "SELECT * FROM ".$tablo_adi."".$sorgu;
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function veriIdGetir($tablo_Adi, $tablo_id_alan, $tablo_id, $sorgu)
    {
        $this->tablo_Adi = $tablo_Adi;
        $this->sorgu = $sorgu;
        $this->tablo_id_alan = $tablo_id_alan;
        $this->tablo_id = $tablo_id;
    
        $query = "SELECT * FROM " . $this->tablo_Adi . ' ' . $this->sorgu . " WHERE " . $this->tablo_id_alan . " = :" . $this->tablo_id_alan;
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':' . $this->tablo_id_alan, $this->tablo_id);
        $stmt->execute();
        return $stmt->fetch();
        
    }
    public function veriEkle($tablo_adi, $sutunlar, $degerler)
    {
        // Resim ekleme kendi sayfasında olacak.
        $sutunStr = implode(', ', $sutunlar);
        $paramStr = implode(', :', $sutunlar);

        $query = "INSERT INTO $tablo_adi($sutunStr) VALUES (:$paramStr)";
        $stmt = $this->connect()->prepare($query);

        $paramArray = array_combine($sutunlar, $degerler);
        $stmt->execute($paramArray);
        
    }
    public function veriDuzenle($tablo_ad, $sutunlar, $kosul, $resimSutun = null)
    {
        $query = "UPDATE $tablo_ad SET ";

        $set = [];
        $params = [];
        // $_POST verilerini işle
        foreach ($sutunlar as $sutun)
        {
            if ($sutun !== $resimSutun)
            {
                $set[] = "$sutun = :$sutun";
                $params[":$sutun"] = $_POST[$sutun] ?? null;
            }
        }
        // Yeni bir resim yüklendi mi ve hata kodu 0 ise
        if ($resimSutun && isset($_FILES[$resimSutun]) && $_FILES[$resimSutun]["error"] == 0)
        {
            $set[] = "$resimSutun = :$resimSutun";
            $params[":$resimSutun"] = $_FILES[$resimSutun]['name'] ?? null;      
        }
        
        $query .= implode(', ', $set);

        if ($kosul)
        {
            $query .= " WHERE $kosul";
        }

        $stmt = $this->connect()->prepare($query);
        return $stmt->execute($params);
    }
    public function veriSil($tablo_ad, $id_alan_isim, $id)
    {
        $query = "DELETE FROM ".$tablo_ad." WHERE ".$id_alan_isim."= ?";
        $stmt = $this->connect()->prepare($query);
        return $stmt->execute([$id]);
    
    } 
}


class Urun extends Db
{
    public function urunGetir()
    {
        $query = "SELECT * FROM urunler";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function sepetEkle($urun_id)
    {   
        // Önce bu üründen sepette kaç adet olduğunu kontrol et
        $query = "SELECT COUNT(*) as adet FROM sepet WHERE urun_id = :urun_id";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute(['urun_id' => $urun_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['adet'] > 0) 
        {
            // Eğer ürün sepette varsa, sadece adetini artır
            $query = "UPDATE sepet SET adet = adet + 1 WHERE urun_id = :urun_id";
            $stmt = $this->connect()->prepare($query);
            return $stmt->execute(['urun_id' => $urun_id]);
        } 
        else
        {
            // Eğer ürün sepette yoksa, yeni olarak ekle
            $query = "INSERT INTO sepet (urun_id, adet) VALUES (:urun_id, 1)";
            $stmt = $this->connect()->prepare($query);
            return $stmt->execute(['urun_id' => $urun_id]);
        }
    }
    public function sepetGetir()
    {
        $query ="SELECT sepet.sepet_id, sepet.adet, urunler.urun_id, urunler.urun_adi, urunler.urun_aciklama, urunler.urun_fiyat
        FROM sepet
        INNER JOIN urunler ON sepet.urun_id = urunler.urun_id";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>