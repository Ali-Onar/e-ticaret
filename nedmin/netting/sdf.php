$sepetkaydet = $db->prepare("INSERT INTO sepetlar SET 
    kullanici_id =:kullanici_id,
    urun_id =:urun_id,
    sepet_detay=:sepet_detay
    ");

    $insert = $sepetkaydet->execute(array(
        'kullanici_id' => $_POST['kullanici_id'],
        'urun_id' => $_POST['urun_id'],
        'sepet_detay' => $_POST['sepet_detay']
    ));

    if ($insert) {
        header("location:$gelen_url?durum=ok");
    } else {
        header("location:$gelen_url?durum=no");
    }
}