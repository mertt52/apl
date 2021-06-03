<?php
$nick=$_GET['nick'];
$yazi="wiwexy pp api";
$session="47719735880%3Aigw2gsGrxPrdJb%3A9";//buraya cookieeditor'den aldıgınız sessionid'i yazın.
$mp=$_SERVER["SERVER_NAME"];
$ppy="https://$mp/resim/$nick";
$yy= "";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/'.$nick.'/?__a=1'); ////This may differ from site to site
//curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Accept-Language: en-US,en;q=0.9',
'Cookie: sessionid='.$session.'',
'Referer: https://www.instagram.com/'.$nick.'/',
'sec-fetch-dest: document',
'sec-fetch-mode: navigate',
'sec-fetch-site: same-origin',
'sec-fetch-user: ?1',
'user-agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

 $result = curl_exec($ch);
$json = json_decode($result, true);

$mavi = $json['graphql']['user']['is_verified'];

$tt=$json['graphql']['user']['edge_followed_by']['count'];

$lusyresim = $json['graphql']['user']['profile_pic_url_hd'];

$img_file = $lusyresim;
// dosyayı okuma ve base 64 ile encode'leme işlemi
$imgData = file_get_contents($lusyresim);
file_put_contents('resim/'.$nick.'.jpg', $imgData);


$dir = "./resim/";
/* 
 * Dizindeki tüm dosyalara işlem uygulanır 
 */
foreach (glob($dir."*") as $file) {
/* 
 * 1 gün = 24 saat = 86400 saniye (12 saatten eski tüm dosyaları siler süreyi değiştirmek için 43200 sayısını değiştirin saat toplamını saniye cinsinden yazınız.
 */
if(time() - filectime($file) > 43200){
unlink($file);
}
}
$bio=$json['graphql']['user']['biography'];
// An associative array
$marks = array(
"bio"=>$bio, 
"pp"=>$ppy,
"mavi"=>$mavi,
"followers"=>$tt,);
  json_encode($marks,JSON_UNESCAPED_SLASHES );
echo $yazi
?>

   
