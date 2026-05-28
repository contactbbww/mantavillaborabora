<?php
$url = $_GET['url'] ?? '';
if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    exit('Invalid URL');
}
if (!preg_match('#^https://www\.airbnb\.(fr|com)/calendar/ical/#', $url)) {
    http_response_code(403);
    exit('URL not allowed');
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/calendar; charset=utf-8');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; CalendarSync/1.0)');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$data = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpCode !== 200 || empty($data)) {
    http_response_code(502);
    exit('Failed to fetch calendar');
}
echo $data;
