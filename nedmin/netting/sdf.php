//yorum SİLME

if ($_GET['yorumsil'] == "ok") {

    $sil = $db->prepare("DELETE from yorum where yorum_id=:yorum_id");
    $kontrol = $sil->execute(array(
        'yorum_id' => $_GET['yorum_id']
    ));

    if ($kontrol) {

        $resimsilunlink = $_GET['yorum_resimyol'];
        unlink("../../$resimsilunlink");

        Header("Location:../production/yorum.php?durum=ok");
    } else {

        Header("Location:../production/yorum.php?durum=no");
    }
}