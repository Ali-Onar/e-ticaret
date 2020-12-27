<?php
include 'header.php';

$yorumsor = $db->prepare("SELECT * FROM yorumlar");
$yorumsor->execute();

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yorumları Listeleme <small>

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

                <?php
                ?>

              </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <!-- Div İçerik Başlangıç -->
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Yorum Tarihi</th>
                  <th>Ad Soyad</th>
                  <th>Ürün Kodu</th>
                  <th>Yorum</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                <?php
                while ($yorumcek = $yorumsor->fetch(PDO::FETCH_ASSOC)) {

                  $kullanici_id = $yorumcek['kullanici_id'];

                  $kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
                  $kullanicisor->execute(array(
                    'id' => $kullanici_id
                  ));
                  $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
                ?>

                  <tr>
                    <td><?php echo $yorumcek['yorum_zaman'] ?></td>
                    <td><?php echo $kullanicicek['kullanici_adsoyad'] ?></td>
                    <td><?php echo $yorumcek['urun_id'] ?></td>
                    <td><?php echo $yorumcek['yorum_detay'] ?></td>
                    <td align="center"><a href="yorum-duzenle.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></td>
                    <td align="center"><a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorumsil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></td>
                  </tr>

                <?php
                }
                ?>

              </tbody>
            </table>
            <!-- Div İçerik Bitiş -->

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