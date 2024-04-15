<?php

require "./danegeh.php";

$kullanıcı_adı = $_GET["kullanıcı_adı"];

$deneme = new Danegeh("deneme", "veri");

$main = $deneme->branch("main");
$verilerim = $deneme->branch("verilerim");

if (!$kullanıcı_adı == null) {
    $verilerim("kullanici_adi", $kullanıcı_adı);
?>
    <script>
        window.location.href = "/deneme.php";
    </script>
<?php }


if (!$verilerim("kullanici_adi") == null) {
    $kullanıcı_adı2 = $verilerim("kullanici_adi");
    echo "<h1>Kullanıcı adınız: $kullanıcı_adı2</h1>";
} else {
?><form action="">
    <input type="text" name="kullanıcı_adı" id="">
</form><?php }

$deneme->push();


