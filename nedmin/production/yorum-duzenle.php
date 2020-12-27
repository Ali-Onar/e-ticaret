<?php
include 'header.php';

$yorumsor = $db->prepare("SELECT * FROM yorumlar where yorum_id=:id");
$yorumsor->execute(array(
    'id' => $_GET['yorum_id']
));
$yorumcek = $yorumsor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Yorum Düzenleme Sayfası <small>

                                <?php
                                if (@$_GET['durum'] == "ok") {
                                ?>
                                    <b style="color:green;">İşlem Başarılı</b>
                                <?php
                                } elseif (@$_GET['durum'] == "no") {
                                ?>
                                    <b style="color:red;">İşlem Başarısız</b>
                                <?php
                                }
                                ?>


                            </small></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                            <?php

                            $kullanici_id = $yorumcek['kullanici_id'];

                            $kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
                            $kullanicisor->execute(array(
                                'id' => $kullanici_id
                            ));
                            $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);


                            $urun_id = $yorumcek['urun_id'];

                            $urunsor = $db->prepare("SELECT * FROM urun where urun_id=:id");
                            $urunsor->execute(array(
                                'id' => $urun_id
                            ));
                            $uruncek = $urunsor->fetch(PDO::FETCH_ASSOC);

                            ?>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Adı <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" disabled="" name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Adı <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" disabled="" name="urun_ad" value="<?php echo $uruncek['urun_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <!-- CK Editor Başlangıç -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yorum Detay <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="ckeditor" id="editor1" name="yorum_detay"><?php echo $yorumcek['yorum_detay'] ?></textarea>
                                </div>
                            </div>

                            <script type="text/javascript">
                                CKEDITOR.replace('editor1', {
                                    filebrowserBrowserUrl: 'ckfinder/ckfinder.html',
                                    filebrowserImageBrowserUrl: 'ckfinder/ckfinder.html?type=Images',
                                    filebrowserFlashBrowserUrl: 'ckfinder/ckfinder.html?type=Flash',
                                    filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                    forcePasteAsPlainText: true
                                });
                            </script>
                            <!-- CK Editor Bitiş -->

                            

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yorum Zaman <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="yorum_zaman" value="<?php echo $yorumcek['yorum_zaman'] ?>" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <input type="hidden" name="yorum_id" value="<?php echo $yorumcek['yorum_id']; ?>">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="yorumduzenle" class="btn btn-primary">Güncelle</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- footer content -->
<?php
include 'footer.php';
?>