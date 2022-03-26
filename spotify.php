<?php
function headerSpotify($body){
$headers = array();
$headers[] = 'User-Agent: Spotify/8.4.98 Android/31 (Realme 6 Pro)';
$headers[] = 'Accept-Language: id-ID;q=1, en-US;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Content-Length: '.strlen($body);
$headers[] = 'Accept-Encoding: gzip';
return $headers;
}
function netPost($body,$headers,$url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
return $result;
}
system("clear"); system("figlet SPOTIFY"); echo "\r\n";
echo "[!] Jumlah yang kamu inginkan : ";
$x = trim(fgets(STDIN));
for ($i = 0; $i < $x;$i++){
$rand = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
$str = substr(str_shuffle($rand), 0, 10);
$email = "$str@gmail.com";
$url = "https://spclient.wg.spotify.com/signup/public/v1/account/";
$body = "birth_year=1990&creation_point=client_mobile&password_repeat=After15shine&email=$email&key=142b583129b2df829de3656f9eb484e6&app_version=849800892&iagree=true&birth_day=2&gender=male&birth_month=9&password=After15shine&platform=Android-ARM";
$headers = headerSpotify($body);
$run = netPost($body,$headers,$url);
$json = json_decode($run, true);
$res = $json["status"];
if($res==20){
	echo "[!] ".$json["errors"]["email"]; echo "\r\n";
	} else if($res==320){
		echo "[!] ".$json["errors"]["generic_error"]; echo "\r\n";
		} else if($res==1){
		$username = $json["username"];
		echo "[!] $email Berhasil Registrasi\n";
		file_put_contents('akunspotify.txt', "$username|After15shine\n", FILE_APPEND);
		} else if($res==130){
			echo "[!] ".$json["errors"]["email"]; echo "\r\n";
			} else {
				die(var_dump($run));
				}



}
?>