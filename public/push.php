<?php 
// 送るメッセージ
$token = $_GET['id'];

$json = '{
"notification":
{
    "title": "タイトルが入ります",
    "body": "本文が入ります",
    "icon": "https://zstg-english.quigen.info/apple-touch-icon-precomposed.png",
    "click_action": "https://zstg-english.quigen.info/"
},
"to": "'.$token.'"
}';

$ch = curl_init();

$headers = array(
    'Content-Type: application/json',
    'Authorization: key=AAAAQ4U9QiY:APA91bGSYhGZD4z_gOhkx5wdbVrRmhHt_6ETd7Vb4nm_mN0-fkTeiIHknXdKtiD2XZXbjX2AiDhjwYK3ScJTlZtyCXr2tA0tmlV3ebl2yk3LlUbgCQaaQnU-9BRY3JVfy4DhpHqkKCuY'
);

curl_setopt_array($ch, array(
    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $json
));

$response = curl_exec($ch);

curl_close($ch);

echo '<pre>';
var_dump($response);
$response = json_decode($response, true);
var_dump($response);

echo '</pre>';

echo 'ok';

?>