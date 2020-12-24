<?php
include 'header.php';



$kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
	'mail' => @$_SESSION['userkullanici_mail']
));
$say = $kullanicisor->rowCount();
$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="bigtitle">Hesap Bilgilerim</div>
							<p>Kullanıcı bilgilerinizi aşağıdan düzenleyebilirsiniz.</p>

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

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<form action="nedmin/netting/islem.php" method="POST" class="form-horizontal checkout" role="form">


		<div class="row">
			<div class="col-md-6">
				<div class="title-bg">
					<div class="title">Kayıt Bilgileri</div>
				</div>
				<!-- Profil Resmi -->
				<center><img width="400" src="dimg/sifremiunuttum.png"></center>

				<div class="form-group dob">
					<div class="col-sm-12">
						<input type="text" class="form-control" required="" name="kullanici_zaman" value="<?php echo $kullanicicek['kullanici_zaman'] ?>">
					</div>
				</div>

				<div class="form-group dob">
					<div class="col-sm-12">
						<input type="text" class="form-control" required="" name="kullanici_tc" value="<?php echo $kullanicicek['kullanici_tc'] ?>">
					</div>
				</div>

				<div class="form-group dob">
					<div class="col-sm-12">
						<input type="text" class="form-control" required="" name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad'] ?>">
					</div>
				</div>

				<div class="form-group dob">
					<div class="col-sm-12">
						<input type="text" class="form-control" required="" name="kullanici_mail" value="<?php echo $kullanicicek['kullanici_mail'] ?>">
					</div>
				</div>



				<button type="submit" name="onkullaniciduzenle" class="btn btn-default btn-red">Bilgilerimi Güncelle</button>
			</div>



		</div>
</div>
</div>
</form>
<div class="spacer"></div>
</div>

<?php include 'footer.php'; ?>