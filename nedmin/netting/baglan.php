<?php
try {
    $db=new PDO("mysql:host=localhost;dbname=eticaret;charset=utf8",'root','');
    //echo "veritabanı bağlantısı başarılı";
}
catch(PDOexception $e) {
    echo $e->getMessage();
}
?>