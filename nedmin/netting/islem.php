<?php
ob_start();
session_start();
include 'baglan.php';
include '../production/fonksiyon.php';

// KULLANICI KAYIT İŞLEMLERİ
if (isset($_POST['kullanicikaydet'])) {
    echo $kullanici_adsoyad = htmlspecialchars($_POST['kullanici_adsoyad']);
    echo "<br>";
    echo $kullanici_mail = htmlspecialchars($_POST['kullanici_mail']);
    echo "<br>";

    echo $kullanici_passwordone = htmlspecialchars($_POST['kullanici_passwordone']);
    echo "<br>";
    echo $kullanici_passwordtwo = htmlspecialchars($_POST['kullanici_passwordtwo']);
    echo "<br>";

    if ($kullanici_passwordone == $kullanici_passwordtwo) {

        if (strlen($kullanici_passwordone) >= 6) {
            // Başlangıç

            $kullanicisor = $db->prepare("select * from kullanici where kullanici_mail=:mail");
            $kullanicisor->execute(array(
                'mail' => $kullanici_mail
            ));

            //dönen satır sayısını belirtir
            $say = $kullanicisor->rowCount();



            if ($say == 0) {

                //md5 fonksiyonu şifreyi md5 şifreli hale getirir.
                $password = md5($kullanici_passwordone);

                $kullanici_yetki = 1;

                //Kullanıcı kayıt işlemi yapılıyor...
                $kullanicikaydet = $db->prepare("INSERT INTO kullanici SET
					kullanici_adsoyad=:kullanici_adsoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
                $insert = $kullanicikaydet->execute(array(
                    'kullanici_adsoyad' => $kullanici_adsoyad,
                    'kullanici_mail' => $kullanici_mail,
                    'kullanici_password' => $password,
                    'kullanici_yetki' => $kullanici_yetki
                ));

                if ($insert) {


                    header("Location:../../index.php?durum=loginbasarili");


                    //Header("Location:../production/genel-ayarlar.php?durum=ok");

                } else {


                    header("Location:../../register.php?durum=basarisiz");
                }
            } else {

                header("Location:../../register.php?durum=mukerrerkayit");
            }

            //Bitiş
        } else {
            header("Location: ../../register.php?durum=eksiksifre");
        }
    } else {
        header("Location: ../../register.php?durum=farklisifre");
    }
}


// SLIDER EKLE RESİM EKLEME
if (isset($_POST['sliderkaydet'])) {

    $uploads_dir = '../../dimg/slider';

    @$tmp_name = $_FILES['slider_resimyol']['tmp_name'];
    @$name = $_FILES['slider_resimyol']['name'];

    $benzersizsayi1 = rand(20000, 32000);
    $benzersizsayi2 = rand(20000, 32000);
    $benzersizsayi3 = rand(20000, 32000);
    $benzersizsayi4 = rand(20000, 32000);
    $benzersizad = $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . $benzersizsayi4;
    $refimgyol = substr($uploads_dir, 6) . "/" . $benzersizad . $name;

    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

    $kaydet = $db->prepare("INSERT into slider SET
    slider_ad=:slider_ad,
    slider_sira=:slider_sira,
    slider_link=:slider_link,
    slider_resimyol=:slider_resimyol");

    $insert = $kaydet->execute(array(
        'slider_ad' => $_POST['slider_ad'],
        'slider_sira' => $_POST['slider_sira'],
        'slider_link' => $_POST['slider_link'],
        'slider_resimyol' => $refimgyol
    ));

    if ($insert) {
        Header("Location:../production/slider.php?durum=ok");
    } else {
        Header("Location:../production/slider.php?durum=no");
    }
}

// SLIDER DÜZENLEME BAŞLANGIÇ
if (isset($_POST['sliderduzenle'])) {

    // resim varsa
    if ($_FILES['slider_resimyol']['size'] > 0) {

        $uploads_dir = '../../dimg/slider';
        @$tmp_name = $_FILES['slider_resimyol']['tmp_name'];
        @$name = $_FILES['slider_resimyol']['name'];

        $benzersizsayi1 = rand(20000, 32000);
        $benzersizsayi2 = rand(20000, 32000);
        $benzersizsayi3 = rand(20000, 32000);
        $benzersizsayi4 = rand(20000, 32000);
        $benzersizad = $benzersizsayi1 . $benzersizsayi2 . $benzersizsayi3 . $benzersizsayi4;
        $refimgyol = substr($uploads_dir, 6) . "/" . $benzersizad . $name;

        @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

        $sliderkaydet = $db->prepare("UPDATE slider SET 
    slider_ad =:slider_ad,
    slider_link=:slider_link,
    slider_sira=:slider_sira,
    slider_durum=:slider_durum,
    slider_resimyol =:slider_resimyol
    WHERE slider_id={$_POST['slider_id']}");

        $update = $sliderkaydet->execute(array(
            'slider_ad' => $_POST['slider_ad'],
            'slider_link' => $_POST['slider_link'],
            'slider_sira' => $_POST['slider_sira'],
            'slider_durum' => $_POST['slider_durum'],
            'slider_resimyol' => $refimgyol
        ));

        $slider_id = $_POST['slider_id'];

        if ($update) {
            $resimsilunlink = $_POST['slider_resimyol'];
            unlink("../../$resimsilunlink");

            header("location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");
        } else {
            header("location:../production/slider-duzenle.php?durum=no");
        }
        // resim yoksa
    } else {

        $sliderkaydet = $db->prepare("UPDATE slider SET 
    slider_ad =:slider_ad,
    slider_resimyol =:slider_resimyol, 
    slider_link=:slider_link,
    slider_sira=:slider_sira,
    slider_durum=:slider_durum
    WHERE slider_id={$_POST['slider_id']}");

        $update = $sliderkaydet->execute(array(
            'slider_ad' => $_POST['slider_ad'],
            'slider_resimyol' => $_POST['slider_resimyol'],
            'slider_link' => $_POST['slider_link'],
            'slider_sira' => $_POST['slider_sira'],
            'slider_durum' => $_POST['slider_durum']
        ));

        $slider_id = $_POST['slider_id'];

        if ($update) {
            header("location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");
        } else {
            header("location:../production/slider-duzenle.php?durum=no");
        }
    }
}
// SLIDER DÜZENLEME BİTİŞ

//SLIDER SİLME

if ($_GET['slidersil'] == "ok") {

    $sil = $db->prepare("DELETE from slider where slider_id=:slider_id");
    $kontrol = $sil->execute(array(
        'slider_id' => $_GET['slider_id']
    ));

    if ($kontrol) {

        $resimsilunlink = $_GET['slider_resimyol'];
        unlink("../../$resimsilunlink");

        Header("Location:../production/slider.php?durum=ok");
    } else {

        Header("Location:../production/slider.php?durum=no");
    }
}


// GENEL AYAR RESİM EKLEME
if (isset($_POST['logoduzenle'])) {

    $uploads_dir = '../../dimg';

    $tmp_name = $_FILES['ayar_logo']['tmp_name'];
    $name = $_FILES['ayar_logo']['name'];

    $benzersizsayi4 = rand(20000, 32000);
    $refimgyol = substr($uploads_dir, 6) . "/" . $benzersizsayi4 . $name;
    // dimg/21189pp.jfif
    move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

    $duzenle = $db->prepare("UPDATE ayar SET
    ayar_logo=:logo
    WHERE ayar_id=0");

    $update = $duzenle->execute(array(
        'logo' => $refimgyol
    ));

    if ($update) {
        $resimsilunlink = $_POST['eski_yol'];
        unlink("../../$resimsilunlink");
        Header("Location:../production/genel-ayar.php?durum=ok");
    } else {
        Header("Location:../production/genel-ayar.php?durum=no");
    }
}

// ADMİN GİRİŞ
if (isset($_POST['admingiris'])) {
    $kullanici_mail = $_POST['kullanici_mail'];
    $kullanici_password = md5($_POST['kullanici_password']);

    $kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki");
    $kullanicisor->execute(array(
        'mail' => $kullanici_mail,
        'password' => $kullanici_password,
        'yetki' => 5
    ));
    echo $say = $kullanicisor->rowCount();

    if (@$say == 1) {
        $_SESSION['kullanici_mail'] = $kullanici_mail;
        header("Location:../production/index.php");
        exit;
    } else {
        header("Location:../production/login.php?durum=no");
        exit;
    }
}

if (isset($_POST['kullanicigiris'])) {

    echo $kullanici_mail = htmlspecialchars($_POST['kullanici_mail']);
    echo $kullanici_password = md5($_POST['kullanici_password']);

    $kullanicisor = $db->prepare("SELECT * from kullanici where kullanici_mail=:mail and kullanici_yetki=:yetki and kullanici_password=:password and kullanici_durum=:durum");
    $kullanicisor->execute(array(
        'mail' => $kullanici_mail,
        'yetki' => 1,
        'password' => $kullanici_password,
        'durum' => 1
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {

        echo $_SESSION['userkullanici_mail'] = $kullanici_mail;

        header("Location:../../");
        exit;
    } else {

        header("Location:../../?durum=basarisizgiris");
    }
}

// GENEL AYARLAR GÜNCELLEME
if (isset($_POST['genelayarkaydet'])) {

    $ayarkaydet = $db->prepare("UPDATE ayar SET 
    ayar_title =:ayar_title,
    ayar_description=:ayar_description,
    ayar_keywords=:ayar_keywords,
    ayar_author=:ayar_author
    WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'ayar_title' => $_POST['ayar_title'],
        'ayar_description' => $_POST['ayar_description'],
        'ayar_keywords' => $_POST['ayar_keywords'],
        'ayar_author' => $_POST['ayar_author']
    ));

    if ($update) {
        header("location:../production/genel-ayar.php?durum=ok");
    } else {
        header("location:../production/genel-ayar.php?durum=no");
    }
}

// İLETİŞİM AYARLAR GÜNCELLEME
if (isset($_POST['iletisimayarkaydet'])) {


    $ayarkaydet = $db->prepare("UPDATE ayar SET 
    ayar_tel =:ayar_tel,
    ayar_gsm=:ayar_gsm,
    ayar_faks=:ayar_faks,
    ayar_mail=:ayar_mail,
    ayar_ilce=:ayar_ilce,
    ayar_il=:ayar_il,
    ayar_adres=:ayar_adres,
    ayar_mesai=:ayar_mesai
    WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'ayar_tel' => $_POST['ayar_tel'],
        'ayar_gsm' => $_POST['ayar_gsm'],
        'ayar_faks' => $_POST['ayar_faks'],
        'ayar_mail' => $_POST['ayar_mail'],
        'ayar_ilce' => $_POST['ayar_ilce'],
        'ayar_il' => $_POST['ayar_il'],
        'ayar_adres' => $_POST['ayar_adres'],
        'ayar_mesai' => $_POST['ayar_mesai']
    ));

    if ($update) {
        header("location:../production/iletisim-ayarlar.php?durum=ok");
    } else {
        header("location:../production/iletisim-ayarlar.php?durum=no");
    }
}

// API AYARLAR GÜNCELLEME
if (isset($_POST['apiayarkaydet'])) {

    $ayarkaydet = $db->prepare("UPDATE ayar SET 
    ayar_analystic =:ayar_analystic,
    ayar_maps=:ayar_maps,
    ayar_zopim=:ayar_zopim
    WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'ayar_analystic' => $_POST['ayar_analystic'],
        'ayar_maps' => $_POST['ayar_maps'],
        'ayar_zopim' => $_POST['ayar_zopim']
    ));

    if ($update) {
        header("location:../production/api-ayarlar.php?durum=ok");
    } else {
        header("location:../production/api-ayarlar.php?durum=no");
    }
}

// SOSYAL AYARLAR GÜNCELLEME
if (isset($_POST['sosyalayarkaydet'])) {

    $ayarkaydet = $db->prepare("UPDATE ayar SET 
    ayar_facebook =:ayar_facebook,
    ayar_twitter=:ayar_twitter,
    ayar_youtube=:ayar_youtube,
    ayar_google=:ayar_google
    WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'ayar_facebook' => $_POST['ayar_facebook'],
        'ayar_twitter' => $_POST['ayar_twitter'],
        'ayar_youtube' => $_POST['ayar_youtube'],
        'ayar_google' => $_POST['ayar_google']
    ));

    if ($update) {
        header("location:../production/sosyal-ayarlar.php?durum=ok");
    } else {
        header("location:../production/sosyal-ayarlar.php?durum=no");
    }
}

// MAIL AYARLAR GÜNCELLEME
if (isset($_POST['mailayarkaydet'])) {

    $ayarkaydet = $db->prepare("UPDATE ayar SET 
    ayar_smtphost =:ayar_smtphost,
    ayar_smtpuser=:ayar_smtpuser,
    ayar_smtppassword=:ayar_smtppassword,
    ayar_smtpport=:ayar_smtpport,
    ayar_bakim=:ayar_bakim
    WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'ayar_smtphost' => $_POST['ayar_smtphost'],
        'ayar_smtpuser' => $_POST['ayar_smtpuser'],
        'ayar_smtppassword' => $_POST['ayar_smtppassword'],
        'ayar_smtpport' => $_POST['ayar_smtpport'],
        'ayar_bakim' => $_POST['ayar_bakim']
    ));

    if ($update) {
        header("location:../production/mail-ayarlar.php?durum=ok");
    } else {
        header("location:../production/mail-ayarlar.php?durum=no");
    }
}


// HAKKIMIZDA GÜNCELLEME
if (isset($_POST['hakkimizdakaydet'])) {

    $ayarkaydet = $db->prepare("UPDATE hakkimizda SET 
    hakkimizda_baslik =:hakkimizda_baslik,
    hakkimizda_icerik=:hakkimizda_icerik,
    hakkimizda_video=:hakkimizda_video,
    hakkimizda_vizyon=:hakkimizda_vizyon,
    hakkimizda_misyon=:hakkimizda_misyon
    WHERE hakkimizda_id = 0");

    $update = $ayarkaydet->execute(array(
        'hakkimizda_baslik' => $_POST['hakkimizda_baslik'],
        'hakkimizda_icerik' => $_POST['hakkimizda_icerik'],
        'hakkimizda_video' => $_POST['hakkimizda_video'],
        'hakkimizda_vizyon' => $_POST['hakkimizda_vizyon'],
        'hakkimizda_misyon' => $_POST['hakkimizda_misyon']
    ));

    if ($update) {
        header("location:../production/hakkimizda.php?durum=ok");
    } else {
        header("location:../production/hakkimizda.php?durum=no");
    }
}

// KULLANICI DÜZENLEME
if (isset($_POST['kullaniciduzenle'])) {

    $kullanici_id = $_POST['kullanici_id'];

    $kullanicikaydet = $db->prepare("UPDATE kullanici SET 
    kullanici_tc =:kullanici_tc,
    kullanici_adsoyad=:kullanici_adsoyad,
    kullanici_durum=:kullanici_durum
    WHERE kullanici_id={$_POST['kullanici_id']}");

    $update = $kullanicikaydet->execute(array(
        'kullanici_tc' => $_POST['kullanici_tc'],
        'kullanici_adsoyad' => $_POST['kullanici_adsoyad'],
        'kullanici_durum' => $_POST['kullanici_durum']
    ));

    if ($update) {
        header("location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
    } else {
        header("location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
    }
}

# HESABIM BİLGİLERİ DÜZENLEME
if (isset($_POST['kullanicibilgiguncelle'])) {

	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_adsoyad' => $_POST['kullanici_adsoyad'],
		'kullanici_il' => $_POST['kullanici_il'],
		'kullanici_ilce' => $_POST['kullanici_ilce']
		));


	if ($update) {

		Header("Location:../../hesabim?durum=ok");

	} else {

		Header("Location:../../hesabim?durum=no");
	}

}

//KULLANICI SİLME
if ($_GET['kullanicisil'] == "ok") {
    $sil = $db->prepare("DELETE FROM kullanici where kullanici_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['kullanici_id']
    ));
    if ($kontrol) {
        header("location:../production/kullanici.php?sil=ok");
    } else {
        header("location:../production/kullanici.php?sil=no");
    }
}



// MENÜ DÜZENLEME
if (isset($_POST['menuduzenle'])) {

    $menu_id = $_POST['menu_id'];
    $menu_seourl = seo($_POST['menu_ad']);

    $menukaydet = $db->prepare("UPDATE menu SET 
    menu_ad =:menu_ad,
    menu_detay=:menu_detay,
    menu_url=:menu_url,
    menu_sira=:menu_sira,
    menu_seourl=:menu_seourl,
    menu_durum=:menu_durum
    WHERE menu_id={$_POST['menu_id']}");

    $update = $menukaydet->execute(array(
        'menu_ad' => $_POST['menu_ad'],
        'menu_detay' => $_POST['menu_detay'],
        'menu_url' => $_POST['menu_url'],
        'menu_sira' => $_POST['menu_sira'],
        'menu_seourl' => $menu_seourl,
        'menu_durum' => $_POST['menu_durum']
    ));

    if ($update) {
        header("location:../production/menu-duzenle.php?menu_id=$menu_id&durum=ok");
    } else {
        header("location:../production/menu-duzenle.php?menu_id=$menu_id&durum=no");
    }
}

//MENÜ SİLME
if ($_GET['menusil'] == "ok") {
    $sil = $db->prepare("DELETE FROM menu where menu_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['menu_id']
    ));
    if ($kontrol) {
        header("location:../production/menu.php?sil=ok");
    } else {
        header("location:../production/menu.php?sil=no");
    }
}

// MENÜ EKLEME
if (isset($_POST['menukaydet'])) {

    $menu_seourl = seo($_POST['menu_ad']);

    $menukaydet = $db->prepare("INSERT into menu SET 
    menu_ad =:menu_ad,
    menu_detay=:menu_detay,
    menu_url=:menu_url,
    menu_sira=:menu_sira,
    menu_seourl=:menu_seourl,
    menu_durum=:menu_durum
    ");

    $insert = $menukaydet->execute(array(
        'menu_ad' => $_POST['menu_ad'],
        'menu_detay' => $_POST['menu_detay'],
        'menu_url' => $_POST['menu_url'],
        'menu_sira' => $_POST['menu_sira'],
        'menu_seourl' => $menu_seourl,
        'menu_durum' => $_POST['menu_durum']
    ));

    if ($insert) {
        header("location:../production/menu.php?durum=ok");
    } else {
        header("location:../production/menu.php?durum=no");
    }
}


// KATEGORİ DÜZENLEME
if (isset($_POST['kategoriduzenle'])) {

    $kategori_id = $_POST['kategori_id'];
    $kategori_seourl = seo($_POST['kategori_ad']);

    $kategorikaydet = $db->prepare("UPDATE kategori SET 
    kategori_ad =:kategori_ad,
    kategori_sira=:kategori_sira,
    kategori_seourl=:kategori_seourl,
    kategori_durum=:kategori_durum
    WHERE kategori_id={$_POST['kategori_id']}");

    $update = $kategorikaydet->execute(array(
        'kategori_ad' => $_POST['kategori_ad'],
        'kategori_sira' => $_POST['kategori_sira'],
        'kategori_seourl' => $kategori_seourl,
        'kategori_durum' => $_POST['kategori_durum']
    ));

    if ($update) {
        header("location:../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=ok");
    } else {
        header("location:../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=no");
    }
}

// KATEGORİ EKLEME
if (isset($_POST['kategoriekle'])) {

    $kategori_seourl = seo($_POST['kategori_ad']);

    $kategorikaydet = $db->prepare("INSERT into kategori SET 
    kategori_ad =:kategori_ad,
    kategori_sira=:kategori_sira,
    kategori_seourl=:kategori_seourl,
    kategori_durum=:kategori_durum
    ");

    $insert = $kategorikaydet->execute(array(
        'kategori_ad' => $_POST['kategori_ad'],
        'kategori_sira' => $_POST['kategori_sira'],
        'kategori_seourl' => $kategori_seourl,
        'kategori_durum' => $_POST['kategori_durum']
    ));

    if ($insert) {
        header("location:../production/kategori.php?durum=ok");
    } else {
        header("location:../production/kategori.php?durum=no");
    }
}

//KATEGORİ SİLME
if ($_GET['kategorisil'] == "ok") {
    $sil = $db->prepare("DELETE FROM kategori where kategori_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['kategori_id']
    ));
    if ($kontrol) {
        header("location:../production/kategori.php?sil=ok");
    } else {
        header("location:../production/kategori.php?sil=no");
    }
}

//ÜRÜN SİLME
if ($_GET['urunsil'] == "ok") {
    $sil = $db->prepare("DELETE FROM urun where urun_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['urun_id']
    ));
    if ($kontrol) {
        header("location:../production/urun.php?sil=ok");
    } else {
        header("location:../production/urun.php?sil=no");
    }
}

//Ürün EKLEME
if (isset($_POST['urunekle'])) {

    $urun_seourl = seo($_POST['urun_ad']);

    $kaydet = $db->prepare("INSERT INTO urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urun_video=:urun_video,
		urun_keyword=:urun_keyword,
		urun_durum=:urun_durum,
		urun_stok=:urun_stok,	
		urun_seourl=:seourl		
		");
    $insert = $kaydet->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'urun_ad' => $_POST['urun_ad'],
        'urun_detay' => $_POST['urun_detay'],
        'urun_fiyat' => $_POST['urun_fiyat'],
        'urun_video' => $_POST['urun_video'],
        'urun_keyword' => $_POST['urun_keyword'],
        'urun_durum' => $_POST['urun_durum'],
        'urun_stok' => $_POST['urun_stok'],
        'seourl' => $urun_seourl

    ));

    if ($insert) {

        Header("Location:../production/urun.php?durum=ok");
    } else {

        Header("Location:../production/urun.php?durum=no");
    }
}

//ÜRÜN DÜZENLE
if (isset($_POST['urunduzenle'])) {

    $urun_id = $_POST['urun_id'];
    $urun_seourl = seo($_POST['urun_ad']);

    $kaydet = $db->prepare("UPDATE urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urun_video=:urun_video,
        urun_onecikar=:urun_onecikar,
		urun_keyword=:urun_keyword,
		urun_durum=:urun_durum,
		urun_stok=:urun_stok,	
		urun_seourl=:seourl		
        WHERE urun_id={$_POST['urun_id']}");

    $update = $kaydet->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'urun_ad' => $_POST['urun_ad'],
        'urun_detay' => $_POST['urun_detay'],
        'urun_fiyat' => $_POST['urun_fiyat'],
        'urun_video' => $_POST['urun_video'],
        'urun_onecikar' => $_POST['urun_onecikar'],
        'urun_keyword' => $_POST['urun_keyword'],
        'urun_durum' => $_POST['urun_durum'],
        'urun_stok' => $_POST['urun_stok'],
        'seourl' => $urun_seourl
    ));

    if ($update) {

        Header("Location:../production/urun-duzenle.php?durum=ok&urun_id=$urun_id");
    } else {

        Header("Location:../production/urun-duzenle.php?durum=no&urun_id=$urun_id");
    }
}


// YORUM EKLEME
if (isset($_POST['yorumkaydet'])) {

    $gelen_url = $_POST['gelen_url'];

    $yorumkaydet = $db->prepare("INSERT INTO yorumlar SET 
    kullanici_id =:kullanici_id,
    urun_id =:urun_id,
    yorum_detay=:yorum_detay
    ");

    $insert = $yorumkaydet->execute(array(
        'kullanici_id' => $_POST['kullanici_id'],
        'urun_id' => $_POST['urun_id'],
        'yorum_detay' => $_POST['yorum_detay']
    ));

    if ($insert) {
        header("location:$gelen_url?durum=ok");
    } else {
        header("location:$gelen_url?durum=no");
    }
}

//YORUM DÜZENLE
if (isset($_POST['yorumduzenle'])) {

    $yorum_id = $_POST['yorum_id'];

    $kaydet = $db->prepare("UPDATE yorumlar SET
		yorum_detay=:yorum_detay,
		yorum_zaman=:yorum_zaman		
        WHERE yorum_id={$_POST['yorum_id']}");

    $update = $kaydet->execute(array(
        'yorum_detay' => $_POST['yorum_detay'],
        'yorum_zaman' => $_POST['yorum_zaman']
    ));

    if ($update) {

        Header("Location:../production/yorum-duzenle.php?durum=ok&yorum_id=$yorum_id");
    } else {

        Header("Location:../production/yorum-duzenle.php?durum=no&yorum_id=$yorum_id");
    }
}

//YORUM SİLME
if ($_GET['yorumsil'] == "ok") {
    $sil = $db->prepare("DELETE FROM yorumlar where yorum_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['yorum_id']
    ));
    if ($kontrol) {
        header("location:../production/yorum.php?sil=ok");
    } else {
        header("location:../production/yorum.php?sil=no");
    }
}

// SEPETE ÜRÜN EKLEME
if (isset($_POST['sepeteekle'])) {


    $sepetkaydet = $db->prepare("INSERT INTO sepet SET 
    kullanici_id =:kullanici_id,
    urun_id =:urun_id,
    urun_adet=:urun_adet
    ");

    $insert = $sepetkaydet->execute(array(
        'kullanici_id' => $_POST['kullanici_id'],
        'urun_id' => $_POST['urun_id'],
        'urun_adet' => $_POST['urun_adet']
    ));

    if ($insert) {
        header("location:../../sepet?durum=ok");
    } else {
        header("location:../../sepet?durum=no");
    }
}

// ÜRÜN ÖNE ÇIKAR
if ($_GET['urun_onecikar']=="ok") {

    $duzenle = $db->prepare("UPDATE urun SET
    urun_onecikar=:urun_onecikar
    WHERE urun_id={$_GET['urun_id']}"
    );

    $update = $duzenle->execute(array(
        'urun_onecikar' => $_GET['urun_one']
    ));

    if ($update) {
        Header("Location:../production/urun.php?durum=ok");
    } else {
        Header("Location:../production/urun.php?durum=no");
    }
}

// YORUM ÖNE ÇIKAR
if ($_GET['yorum_onay']=="ok") {

    $duzenle = $db->prepare("UPDATE yorumlar SET
    
    yorum_onay=:yorum_onay

    WHERE yorum_id={$_GET['yorum_id']}"
    );

    $update = $duzenle->execute(array(
        'yorum_onay' => $_GET['yorum_one']
    ));

    if ($update) {
        Header("Location:../production/yorum.php?durum=ok");
    } else {
        Header("Location:../production/yorum.php?durum=no");
    }
}

//YORUM SİLME
if ($_GET['yorumsil'] == "ok") {

    $sil = $db->prepare("DELETE from yorumlar where yorum_id=:yorum_id");
    $kontrol = $sil->execute(array(
        'yorum_id' => $_GET['yorum_id']
    ));

    if ($kontrol) {

        Header("Location:../production/yorum.php?durum=ok");
    } else {

        Header("Location:../production/yorum.php?durum=no");
    }
}


if (isset($_POST['kullanicisifreguncelle'])) {

	echo $kullanici_eskipassword=trim($_POST['kullanici_eskipassword']); echo "<br>";
	echo $kullanici_passwordone=trim($_POST['kullanici_passwordone']); echo "<br>";
	echo $kullanici_passwordtwo=trim($_POST['kullanici_passwordtwo']); echo "<br>";

	$kullanici_password=md5($kullanici_eskipassword);


	$kullanicisor=$db->prepare("select * from kullanici where kullanici_password=:password");
	$kullanicisor->execute(array(
		'password' => $kullanici_password
		));

			//dönen satır sayısını belirtir
	$say=$kullanicisor->rowCount();

	if ($say==0) {

		header("Location:../../sifre-guncelle?durum=eskisifrehata");

	} else {

	//eski şifre doğruysa başla

		if ($kullanici_passwordone==$kullanici_passwordtwo) {


			if (strlen($kullanici_passwordone)>=6) {


				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;

				$kullanicikaydet=$db->prepare("UPDATE kullanici SET
					kullanici_password=:kullanici_password
					WHERE kullanici_id={$_POST['kullanici_id']}");

				
				$insert=$kullanicikaydet->execute(array(
					'kullanici_password' => $password
					));

				if ($insert) {


					header("Location:../../sifre-guncelle.php?durum=sifredegisti");


				//Header("Location:../production/genel-ayarlar.php?durum=ok");

				} else {


					header("Location:../../sifre-guncelle.php?durum=no");
				}

		// Bitiş

			} else {


				header("Location:../../sifre-guncelle.php?durum=eksiksifre");
			}

		} else {

			header("Location:../../sifre-guncelle?durum=sifreleruyusmuyor");

			exit;

		}

	}

	exit;

	if ($update) {

		header("Location:../../sifre-guncelle?durum=ok");

	} else {

		header("Location:../../sifre-guncelle?durum=no");
	}

}


if(isset($_POST['urunfotosil'])) {

	$urun_id=$_POST['urun_id'];


	echo $checklist = $_POST['urunfotosec'];

	
	foreach($checklist as $list) {

		$sil=$db->prepare("DELETE from urunfoto where urunfoto_id=:urunfoto_id");
		$kontrol=$sil->execute(array(
			'urunfoto_id' => $list
			));
	}

	if ($kontrol) {

		Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=ok");

	} else {

		Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=no");
	}


} 

