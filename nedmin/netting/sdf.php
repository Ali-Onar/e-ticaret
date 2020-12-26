$yorumsor = $db->prepare("SELECT * FROM yorumlar where yorum_seourl=:seourl");
	$yorumsor->execute(array(
		'seourl' => $_GET['sef']
	));
	$yorumcek = $yorumsor->fetch(PDO::FETCH_ASSOC);