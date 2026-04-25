<?php
$apiKey = "hSPjo6dvdgFyNfRBO7EVRQ==31s6QTzAQhWCWldf";
$url = "https://api.api-ninjas.com/v1/exercises?muscle=abdominals";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Api-Key: " . $apiKey
]);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);