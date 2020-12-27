$sepetsor = $db->prepare("SELECT * FROM sepet where sepet_id=:id");
$sepetsor->execute(array(
  'id' => $_GET['sepet_id']
));
$sepetcek = $sepetsor->fetch(PDO::FETCH_ASSOC);