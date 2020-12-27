//ÜRÜN DÜZENLE
if (isset($_POST['yorumduzenle'])) {

	$yorum_id=$_POST['yorum_id'];
	$yorum_seourl=seo($_POST['yorum_ad']);

	$kaydet=$db->prepare("UPDATE yorum SET
		kategori_id=:kategori_id,
		yorum_ad=:yorum_ad,
		yorum_detay=:yorum_detay,
		yorum_fiyat=:yorum_fiyat,
		yorum_video=:yorum_video,
        yorum_onecikar=:yorum_onecikar,
		yorum_keyword=:yorum_keyword,
		yorum_durum=:yorum_durum,
		yorum_stok=:yorum_stok,	
		yorum_seourl=:seourl		
        WHERE yorum_id={$_POST['yorum_id']}");
        
	$update=$kaydet->execute(array(
		'kategori_id' => $_POST['kategori_id'],
		'yorum_ad' => $_POST['yorum_ad'],
		'yorum_detay' => $_POST['yorum_detay'],
		'yorum_fiyat' => $_POST['yorum_fiyat'],
        'yorum_video' => $_POST['yorum_video'],
        'yorum_onecikar' => $_POST['yorum_onecikar'],
		'yorum_keyword' => $_POST['yorum_keyword'],
		'yorum_durum' => $_POST['yorum_durum'],
		'yorum_stok' => $_POST['yorum_stok'],
		'seourl' => $yorum_seourl
		));

	if ($update) {

		Header("Location:../production/yorum-duzenle.php?durum=ok&yorum_id=$yorum_id");

	} else {

		Header("Location:../production/yorum-duzenle.php?durum=no&yorum_id=$yorum_id");
	}

}