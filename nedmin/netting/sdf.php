// MENÜ EKLEME
if (isset($_POST['yorumkaydet'])) {

    $yorum_seourl = seo($_POST['yorum_ad']);

    $yorumkaydet = $db->prepare("INSERT into yorum SET 
    yorum_ad =:yorum_ad,
    yorum_detay=:yorum_detay,
    yorum_url=:yorum_url,
    yorum_sira=:yorum_sira,
    yorum_seourl=:yorum_seourl,
    yorum_durum=:yorum_durum
    ");

    $insert = $yorumkaydet->execute(array(
        'yorum_ad' => $_POST['yorum_ad'],
        'yorum_detay' => $_POST['yorum_detay'],
        'yorum_url' => $_POST['yorum_url'],
        'yorum_sira' => $_POST['yorum_sira'],
        'yorum_seourl' => $yorum_seourl,
        'yorum_durum' => $_POST['yorum_durum']
    ));

    if ($insert) {
        header("location:../production/yorum.php?durum=ok");
    } else {
        header("location:../production/yorum.php?durum=no");
    }
}