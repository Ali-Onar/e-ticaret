// KATEGORİ DÜZENLEME
if (isset($_POST['urunduzenle'])) {

    $urun_id = $_POST['urun_id'];
    $urun_seourl = seo($_POST['urun_ad']);

    $urunkaydet = $db->prepare("UPDATE urun SET 
    urun_ad =:urun_ad,
    urun_sira=:urun_sira,
    urun_seourl=:urun_seourl,
    urun_durum=:urun_durum
    WHERE urun_id={$_POST['urun_id']}");

    $update = $urunkaydet->execute(array(
        'urun_ad' => $_POST['urun_ad'],
        'urun_sira' => $_POST['urun_sira'],
        'urun_seourl' => $urun_seourl,
        'urun_durum' => $_POST['urun_durum']
    ));

    if ($update) {
        header("location:../production/urun-duzenle.php?urun_id=$urun_id&durum=ok");
    } else {
        header("location:../production/urun-duzenle.php?urun_id=$urun_id&durum=no");
    }
}