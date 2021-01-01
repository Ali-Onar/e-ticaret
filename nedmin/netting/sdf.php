$urunfotosor = $db->prepare("SELECT * FROM urunfoto order by urunfoto_id DESC");
$urunfotosor->execute();